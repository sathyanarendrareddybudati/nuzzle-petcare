DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS communication_log;
DROP TABLE IF EXISTS faqs;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS pet_ads;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS locations;
DROP TABLE IF EXISTS pet_categories;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO roles (name, description) VALUES 
('admin', 'Administrator with full access'),
('pet_owner', 'Pet owner who can post ads and book services'),
('service_provider', 'Service provider who can offer services');

CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    pin_code INT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO locations (name, city, state, country, pin_code) VALUES 
('Downtown', 'New York', 'NY', 'USA', 10001),
('Westside', 'Los Angeles', 'CA', 'USA', 90001),
('Central', 'Chicago', 'IL', 'USA', 60601);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15),
    location_id INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_user_role FOREIGN KEY (role_id) REFERENCES roles(id),
    CONSTRAINT fk_user_location FOREIGN KEY (location_id) REFERENCES locations(id)
);

-- 4. PET_CATEGORIES Table
CREATE TABLE pet_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Insert some pet categories
INSERT INTO pet_categories (name, description) VALUES 
('Dogs', 'All dog breeds'),
('Cats', 'All cat breeds'),
('Birds', 'All bird species'),
('Small Pets', 'Rabbits, hamsters, guinea pigs, etc.');

-- 5. SERVICES Table
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_service_category FOREIGN KEY (category_id) REFERENCES pet_categories(id)
);

-- Insert some services
INSERT INTO services (category_id, name, description) VALUES 
(1, 'Dog Walking', 'Professional dog walking services'),
(1, 'Pet Sitting', 'In-home pet sitting for dogs'),
(2, 'Cat Sitting', 'In-home cat sitting services'),
(3, 'Bird Grooming', 'Professional bird grooming');

-- 6. PET_ADS Table
CREATE TABLE pet_ads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    cost DECIMAL(10,2),
    status VARCHAR(50) NOT NULL DEFAULT 'active',
    start_date TIMESTAMP NOT NULL,
    end_date TIMESTAMP NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    location_id INT NOT NULL,
    CONSTRAINT fk_ad_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_ad_service FOREIGN KEY (service_id) REFERENCES services(id),
    CONSTRAINT fk_ad_location FOREIGN KEY (location_id) REFERENCES locations(id)
);

-- 7. BOOKINGS Table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_ad_id INT NOT NULL,
    provider_id INT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    notes TEXT,
    CONSTRAINT fk_booking_ad FOREIGN KEY (pet_ad_id) REFERENCES pet_ads(id) ON DELETE CASCADE,
    CONSTRAINT fk_booking_provider FOREIGN KEY (provider_id) REFERENCES users(id)
);

-- 8. FAQS Table
CREATE TABLE faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_faq_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 9. COMMUNICATION_LOG Table
CREATE TABLE communication_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_user_id INT,
    recipient_user_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body_content TEXT NOT NULL,
    communication_type ENUM('email', 'sms', 'notification') NOT NULL,
    delivery_status ENUM('pending', 'sent', 'delivered', 'failed') NOT NULL DEFAULT 'pending',
    sent_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL,
    CONSTRAINT fk_comm_sender FOREIGN KEY (sender_user_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_comm_recipient FOREIGN KEY (recipient_user_id) REFERENCES users(id)
);

-- 10. DOCUMENTS Table
CREATE TABLE documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    document_type ENUM('id_proof', 'address_proof', 'certification', 'other') NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    file_type VARCHAR(100) NOT NULL,
    is_verified BOOLEAN NOT NULL DEFAULT FALSE,
    verified_by INT,
    verified_at TIMESTAMP NULL,
    uploaded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    CONSTRAINT fk_doc_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_doc_verified_by FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Create indexes for better performance
CREATE INDEX idx_pet_ads_status ON pet_ads(status);
CREATE INDEX idx_bookings_status ON bookings(status);
CREATE INDEX idx_communication_log_recipient ON communication_log(recipient_user_id);
CREATE INDEX idx_documents_user ON documents(user_id, document_type);
