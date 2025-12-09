-- Database schema for PetCare

CREATE DATABASE IF NOT EXISTS petcare;
USE petcare;

CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    species VARCHAR(50) NOT NULL,
    breed VARCHAR(100),
    age INT,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    location VARCHAR(255) NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    contact_email VARCHAR(100),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO pets (name, species, breed, age, gender, price, description, location, contact_phone, contact_email, image_url) VALUES
('Max', 'Dog', 'Golden Retriever', 2, 'Male', 500.00, 'Friendly and playful golden retriever. Loves kids and other pets.', 'New York', '+1234567890', 'seller1@example.com', 'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=500&auto=format&fit=crop&q=60'),
('Luna', 'Cat', 'Siamese', 1, 'Female', 300.00, 'Beautiful blue-eyed siamese cat. Litter trained and very affectionate.', 'Los Angeles', '+1987654321', 'seller2@example.com', 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500&auto=format&fit=crop&q=60'),
('Buddy', 'Dog', 'Labrador', 3, 'Male', 450.00, 'Well-trained labrador. Great with families and loves to play fetch.', 'Chicago', '+1122334455', 'seller3@example.com', 'https://images.unsplash.com/photo-1544568100-847a948585b9?w=500&auto=format&fit=crop&q=60');
