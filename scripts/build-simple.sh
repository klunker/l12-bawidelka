#!/bin/bash

# Simple build script with environment variables
# Usage: ./build-simple.sh

set -e

# Source common functions
source "$(dirname "$0")/common.sh"

# Environment variables for build optimization
export UV_THREADPOOL_SIZE=1
export RAYON_NUM_THREADS=1

echo "🔧 Environment variables set:"
echo "   UV_THREADPOOL_SIZE=${UV_THREADPOOL_SIZE}"
echo "   RAYON_NUM_THREADS=${RAYON_NUM_THREADS}"

# Colors are now loaded from common.sh

print_status "Starting simple build process..."
print_status "Running: npm run build"

if npm run build; then
    print_success "Build completed successfully!"
    
    # Show build artifacts
    if [[ -d "public/build" ]]; then
        print_status "Build artifacts created:"
        ls -la public/build/ | head -5
    fi
else
    echo "❌ Build failed!"
    exit 1
fi
