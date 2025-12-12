#!/bin/bash

echo "🚀 Starting Docker setup for 2PSS Sneaker..."

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker first."
    exit 1
fi

echo "✅ Docker is running"

# Copy env file if not exists
if [ ! -f .env ]; then
    echo "📝 Copying .env.docker to .env..."
    cp .env.docker .env
    echo "✅ .env file created"
else
    echo "⚠️  .env already exists. Skipping..."
fi

# Build and start containers
echo "🏗️  Building Docker containers..."
docker-compose up -d --build

echo "⏳ Waiting for services to start..."
sleep 10

# Install composer dependencies
echo "📦 Installing Composer dependencies..."
docker-compose exec -T app composer install --no-interaction

# Generate app key
echo "🔑 Generating application key..."
docker-compose exec -T app php artisan key:generate

# Run migrations
echo "🗄️  Running database migrations..."
docker-compose exec -T app php artisan migrate --force

# Seed database (optional)
read -p "Do you want to seed the database? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    echo "🌱 Seeding database..."
    docker-compose exec -T app php artisan db:seed
fi

# Set permissions
echo "🔒 Setting permissions..."
docker-compose exec -T app chmod -R 777 storage bootstrap/cache

echo ""
echo "✨ Setup complete! ✨"
echo ""
echo "🌐 Access your services:"
echo "   - Website:       http://localhost:8080"
echo "   - phpMyAdmin:    http://localhost:8081"
echo "   - MinIO Console: http://localhost:9001"
echo ""
echo "📊 MinIO Credentials:"
echo "   - User: minioadmin"
echo "   - Pass: minioadmin123"
echo ""
echo "🗄️  MySQL Credentials:"
echo "   - Host: localhost:3306"
echo "   - Database: laravel_db"
echo "   - User: laravel_user"
echo "   - Pass: laravel_pass"
echo ""
echo "🛠️  Useful commands:"
echo "   - View logs:     docker-compose logs -f"
echo "   - Stop:          docker-compose down"
echo "   - Restart:       docker-compose restart"
echo "   - Enter app:     docker-compose exec app bash"
echo ""
