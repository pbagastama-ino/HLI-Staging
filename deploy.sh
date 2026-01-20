#!/bin/bash
# ============================================
# HLI Green Power Website Deployment Script
# ============================================

echo "🚀 Starting deployment for HLI Green Power..."

# Step 1: Pull latest code
echo "📥 Pulling latest code..."
git pull origin main

# Step 2: Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Step 3: Install and build frontend
echo "🧱 Building frontend assets..."
npm ci
npm run build

# Step 4: Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Step 5: Clear and cache optimization
echo "⚡ Optimizing Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Step 6: Fix permissions
echo "🔧 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Deployment completed successfully!"
