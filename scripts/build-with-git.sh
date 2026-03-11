#!/bin/bash

# Git-aware build script with environment variables for build optimization
# Usage: ./build-with-git.sh [force]

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

# Check if we're in a git repository
if ! git rev-parse --git-dir > /dev/null 2>&1; then
    print_error "Not in a git repository!"
    exit 1
fi

print_status "Checking git status..."

# Check for uncommitted changes
if [[ -n $(git status --porcelain) ]]; then
    print_warning "You have uncommitted changes:"
    git status --short
    
    if [[ "$1" != "force" ]]; then
        read -p "Do you want to continue anyway? (y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            print_status "Build cancelled."
            exit 0
        fi
    fi
fi

# Get current branch and remote info
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
DEFAULT_REMOTE="origin"

print_status "Current branch: ${CURRENT_BRANCH}"

# Check if remote exists
if git remote | grep -q "$DEFAULT_REMOTE"; then
    print_status "Fetching from remote: $DEFAULT_REMOTE"
    git fetch "$DEFAULT_REMOTE" "$CURRENT_BRANCH" --quiet
    
    # Check for new commits
    LOCAL=$(git rev-parse "$CURRENT_BRANCH")
    REMOTE=$(git rev-parse "$DEFAULT_REMOTE/$CURRENT_BRANCH")
    
    if [[ "$LOCAL" != "$REMOTE" ]]; then
        print_warning "Your branch is behind remote. Found new commits."
        
        if [[ "$1" != "force" ]]; then
            read -p "Do you want to pull latest changes? (Y/n): " -n 1 -r
            echo
            if [[ ! $REPLY =~ ^[Nn]$ ]]; then
                print_status "Pulling latest changes..."
                git pull "$DEFAULT_REMOTE" "$CURRENT_BRANCH"
                print_success "Latest changes pulled successfully."
            fi
        else
            print_status "Force mode: pulling latest changes..."
            git pull "$DEFAULT_REMOTE" "$CURRENT_BRANCH"
            print_success "Latest changes pulled successfully."
        fi
    else
        print_success "Your branch is up to date."
    fi
else
    print_warning "No remote '$DEFAULT_REMOTE' found. Skipping git pull."
fi

# Check if package-lock.json has changed (indicating dependency changes)
if git diff --name-only HEAD~1 HEAD 2>/dev/null | grep -q "package.json\|package-lock.json"; then
    print_warning "Dependencies have changed. Running npm install..."
    npm install
fi

# Run the build
print_status "Starting build process..."
print_status "Running: npm run build"

if npm run build; then
    print_success "Build completed successfully!"
    
    # Show build artifacts
    if [[ -d "public/build" ]]; then
        print_status "Build artifacts created:"
        ls -la public/build/ | head -10
    fi
    
    # Show git commit info
    print_status "Build details:"
    echo "   Commit: $(git rev-parse --short HEAD)"
    echo "   Branch: $(git rev-parse --abbrev-ref HEAD)"
    echo "   Date: $(git log -1 --format=%cd --date=short)"
    echo "   Message: $(git log -1 --format=%s)"
    
else
    print_error "Build failed!"
    exit 1
fi
