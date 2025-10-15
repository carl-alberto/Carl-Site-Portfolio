#!/bin/bash
set -e

# Write SSH key from env to a file
echo "$SSH_PRIVATE_KEY" > deploy_key
chmod 600 deploy_key

echo "Deploy to:"
echo "$DEPLOY_USER"
echo "$DEPLOY_HOST"

# Run composer on mu-plugins & themes
cd mu-plugins/10up-plugin
composer install --no-dev --optimize-autoloader
npm install
npm run build

cd ../../themes/10up-block-theme/
composer install --no-dev --optimize-autoloader
npm install
npm run build
cd ../..

# Rsync selected folders/files to remote server using custom port 2222 in Pantheon servers
rsync -avz -e "ssh -i deploy_key -p 2222 -o StrictHostKeyChecking=no" themes mu-plugins $DEPLOY_USER@$DEPLOY_HOST:/code/wp-content/

# Clean up
rm deploy_key
