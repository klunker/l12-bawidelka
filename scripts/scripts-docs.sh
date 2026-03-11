#!/bin/bash

# Scripts documentation generator
# Usage: ./scripts-docs.sh

echo "# 📦 Available Scripts"
echo ""
echo "Generated from package.json scripts"
echo "==============================="
echo ""

# Parse package.json and generate documentation
if [[ -f "package.json" ]]; then
    echo "## 🏗️ Build Scripts"
    echo "| Script | Description |"
    echo "|--------|-------------|"
    
    # Extract build scripts
    jq -r '.scripts | to_entries[] | select(.key | startswith("build")) | "| \`npm run \(.key)\` | \(.value) |"' package.json | while read line; do
        if [[ $line == *"build"* ]]; then
            echo "$line"
        fi
    done
    
    echo ""
    echo "## 🧪 CI/Testing Scripts"
    echo "| Script | Description |"
    echo "|--------|-------------|"
    
    # Extract CI scripts
    jq -r '.scripts | to_entries[] | select(.key | startswith("ci") or .key | startswith("act")) | "| \`npm run \(.key)\` | \(.value) |"' package.json | while read line; do
        if [[ $line == *"ci"* || $line == *"act"* ]]; then
            echo "$line"
        fi
    done
    
    echo ""
    echo "## 🛠️ Development Scripts"
    echo "| Script | Description |"
    echo "|--------|-------------|"
    
    # Extract dev scripts
    jq -r '.scripts | to_entries[] | select(.key | startswith("dev") or .key | startswith("format") or .key | startswith("lint") or .key | startswith("types")) | "| \`npm run \(.key)\` | \(.value) |"' package.json | while read line; do
        if [[ $line == *"dev"* || $line == *"format"* || $line == *"lint"* || $line == *"types"* ]]; then
            echo "$line"
        fi
    done
else
    echo "❌ package.json not found!"
    exit 1
fi

echo ""
echo "📅 Generated: $(date)"
echo "🔧 Tool: scripts-docs.sh"
