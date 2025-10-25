#!/bin/bash

# Copy .env.example to .env if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env file from .env.example"
else
    echo ".env file already exists, skipping..."
fi

# Install Composer dependencies
composer install --no-dev --optimize-autoloader

echo "Setup complete! Please edit the .env file with your database credentials and other settings."
