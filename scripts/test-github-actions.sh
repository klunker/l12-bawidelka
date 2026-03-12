#!/bin/bash

# Local GitHub Actions testing script
# Usage: ./test-github-actions.sh [lint|tests|all]

set -e

# Source common functions
source "$(dirname "$0")/common.sh"

# Colors are now loaded from common.sh

# Check if Docker is available
if ! command -v docker &> /dev/null; then
    print_error "Docker is not installed or not in PATH"
    exit 1
fi

# Parse arguments
ACTION=${1:-"all"}

print_header "GitHub Actions Local Test Runner"
print_status "Testing GitHub Actions locally: $ACTION"

# Function to run lint workflow
run_lint() {
    print_status "🧹 Running LINT workflow..."
    
    docker run --rm \
        -u root \
        -v "$PWD":/app \
        -w /app \
        -e CI=true \
        -e DB_CONNECTION=sqlite \
        -e DB_DATABASE=":memory:" \
        -e CACHE_STORE=array \
        -e LARAVEL_SKIP_DATABASE_CHECK=1 \
        -e HOST_UID=$(id -u) \
        -e HOST_GID=$(id -g) \
        bitnami/laravel:latest \
        bash -c "
            echo '📦 Installing dependencies...'
            composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
            npm install
            
            echo '🔍 Running Pint...'
            composer lint
            
            echo '🎨 Formatting frontend...'
            npm run format
            
            echo '🔍 Linting frontend...'
            npm run lint
            
            echo '✅ Lint workflow completed successfully!'
            chown -R \$HOST_UID:\$HOST_GID /app
        "
}

# Function to run tests workflow
run_tests() {
    print_status "🧪 Running TESTS workflow..."
    
    # Test with PHP 8.4
    print_status "Testing with PHP 8.4..."
    docker run --rm \
        -u root \
        -v "$PWD":/app \
        -w /app \
        -e CI=true \
        -e DB_CONNECTION=sqlite \
        -e DB_DATABASE=":memory:" \
        -e CACHE_STORE=array \
        -e LARAVEL_SKIP_DATABASE_CHECK=1 \
        -e HOST_UID=$(id -u) \
        -e HOST_GID=$(id -g) \
        bitnami/laravel:latest \
        bash -c "
            echo '📦 Installing dependencies...'
            composer install --no-interaction --prefer-dist --optimize-autoloader
            
            echo '📋 Copying environment file...'
            cp .env.example .env
            
            echo '🔑 Generating application key...'
            php artisan key:generate
            
            echo '🏗️  Building assets...'
            npm run build
            
            echo '🧪 Running tests...'
            ./vendor/bin/pest
            
            echo '✅ Tests completed successfully!'
            chown -R \$HOST_UID:\$HOST_GID /app
        "
    
    # Test with PHP 8.5
    print_status "Testing with PHP 8.5..."
    docker run --rm \
        -u root \
        -v "$PWD":/app \
        -w /app \
        -e CI=true \
        -e DB_CONNECTION=sqlite \
        -e DB_DATABASE=":memory:" \
        -e CACHE_STORE=array \
        -e LARAVEL_SKIP_DATABASE_CHECK=1 \
        -e HOST_UID=$(id -u) \
        -e HOST_GID=$(id -g) \
        bitnami/laravel:latest \
        bash -c "
            echo '📦 Installing dependencies...'
            composer install --no-interaction --prefer-dist --optimize-autoloader
            
            echo '🧪 Running tests...'
            ./vendor/bin/pest
            
            echo '✅ Tests with PHP 8.5 completed successfully!'
            chown -R \$HOST_UID:\$HOST_GID /app
        "
}

# Function to simulate full CI environment
run_full_ci() {
    print_status "🚀 Running FULL CI simulation..."
    
    # Create temporary CI environment
    CI_DIR=$(mktemp -d)
    trap "rm -rf $CI_DIR" EXIT
    
    print_status "📋 Setting up CI environment..."
    
    # Copy project to temp directory
    cp -r . "$CI_DIR/project"
    cd "$CI_DIR/project"
    
    # Run lint
    run_lint
    
    # Run tests
    run_tests
    
    cd - > /dev/null
    print_success "🎉 Full CI simulation completed!"
}

# Main execution
case "$ACTION" in
    "lint")
        run_lint
        ;;
    "tests")
        run_tests
        ;;
    "all")
        run_full_ci
        ;;
    "list")
        print_status "📋 Available options:"
        echo "  lint   - Run lint workflow"
        echo "  tests  - Run tests workflow" 
        echo "  all    - Run full CI simulation"
        ;;
    *)
        print_error "Unknown action: $ACTION"
        echo "Usage: $0 [lint|tests|all|list]"
        exit 1
        ;;
esac

print_success "🎊 Local GitHub Actions test completed!"
