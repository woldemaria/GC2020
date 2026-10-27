#!/bin/bash

# GC Magazine Website Deployment Script
# Usage: ./deploy.sh [environment]
# Environments: development, production

ENVIRONMENT=${1:-development}

echo "🚀 Starting GC Magazine Website deployment..."
echo "Environment: $ENVIRONMENT"

# Check if composer exists
if ! command -v composer &> /dev/null; then
    echo "❌ Composer not found. Please install Composer first."
    exit 1
fi

# Check if npm exists
if ! command -v npm &> /dev/null; then
    echo "❌ NPM not found. Please install Node.js and NPM first."
    exit 1
fi

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
if [ "$ENVIRONMENT" = "production" ]; then
    composer install --optimize-autoloader --no-dev
else
    composer install
fi

# Install NPM dependencies
echo "📦 Installing NPM dependencies..."
npm install

# Setup environment
if [ ! -f .env ]; then
    echo "📄 Creating .env file..."
    cp .env.example .env
    php artisan key:generate
fi

# Database setup
echo "🗄️ Setting up database..."
if [ ! -f database/database.sqlite ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate --force

# Seed database (only in development)
if [ "$ENVIRONMENT" = "development" ]; then
    echo "🌱 Seeding database..."
    php artisan db:seed --force
fi

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link

# Create required directories
echo "📁 Creating required directories..."
mkdir -p storage/app/public/images/{articles,avatars,gallery,uploads,thumbnails}

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/app/public

# Build assets
echo "🎨 Building assets..."
if [ "$ENVIRONMENT" = "production" ]; then
    npm run build
    
    # Optimize for production
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    npm run build
fi

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear

echo "✅ Deployment complete!"
echo ""
echo "🌐 Application URLs:"
echo "   Main Website: http://localhost:8000"
echo "   Admin Panel:  http://localhost:8000/admin"
echo "   Login Page:   http://localhost:8000/login"
echo ""
echo "🔑 Test Credentials:"
echo "   Admin: admin@gcmagazine.edu / password"
echo "   Editor: editor@gcmagazine.edu / password"
echo ""
echo "🚦 To start the application:"
echo "   Development: php artisan serve"
echo "   Production:  Configure your web server to serve the public/ directory"
echo ""