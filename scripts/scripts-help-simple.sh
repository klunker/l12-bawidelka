#!/bin/bash

# Interactive scripts helper (no colors version)
# Usage: ./scripts-help-simple.sh [script-name|category]

set -e

print_header() {
    echo "🚀 Available Scripts Helper"
    echo "=========================="
}

print_category() {
    echo ""
    echo "📂 $1"
    echo "===================="
}

print_script() {
    local script=$1
    local command=$2
    echo "• $script → $command"
}

print_usage() {
    echo "Usage: $0 [script-name]"
    echo "       $0 [category]"
    echo ""
    echo "Categories: build, ci, dev, all"
    echo ""
    echo "Examples:"
    echo "  $0 build:simple"
    echo "  $0 build"
    echo "  $0 ci"
    echo "  $0 all"
}

# Parse package.json scripts using sed
parse_package_json() {
    local file="$1"
    
    # Extract scripts section and clean it up
    sed -n '/scripts/,/}/p' "$file" | \
        grep -v "scripts\|}" | \
        sed 's/^[[:space:]]*//' | \
        sed 's/,$//' | \
        sed 's/^"\([^"]*\)":\s*"\([^"]*\)"/\1|\2/'
}

# Check if package.json exists
if [[ ! -f "package.json" ]]; then
    echo "❌ package.json not found!"
    exit 1
fi

# Parse scripts from package.json
declare -A scripts
while IFS='|' read -r key value; do
    if [[ -n "$key" && -n "$value" ]]; then
        scripts["$key"]="$value"
    fi
done < <(parse_package_json package.json)

print_header

# Filter and display scripts
filter=${1:-"all"}

case "$filter" in
    "build")
        print_category "🏗️ Build Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == build* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        ;;
    "ci")
        print_category "🧪 CI/Testing Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == ci* || $key == act* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        ;;
    "dev")
        print_category "🛠️ Development Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == dev* || $key == format* || $key == lint* || $key == types* || $key == help* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        ;;
    "all")
        print_category "🏗️ Build Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == build* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        
        print_category "🧪 CI/Testing Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == ci* || $key == act* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        
        print_category "🛠️ Development Scripts"
        for key in "${!scripts[@]}"; do
            if [[ $key == dev* || $key == format* || $key == lint* || $key == types* || $key == help* ]]; then
                print_script "$key" "${scripts[$key]}"
            fi
        done
        ;;
    *)
        # Check if it's a specific script
        if [[ -n "${scripts[$filter]}" ]]; then
            print_category "📋 Script Details"
            echo "🔧 $filter"
            echo "⚡ ${scripts[$filter]}"
            echo ""
            echo "▶️  Run with: npm run $filter"
        else
            print_usage
            exit 1
        fi
        ;;
esac

echo ""
echo "💡 Tips:"
echo "  • Use ./scripts-help.sh build to see build scripts only"
echo "  • Use ./scripts-help.sh ci to see CI scripts only"
echo "  • Use ./scripts-help.sh script-name for specific script details"
