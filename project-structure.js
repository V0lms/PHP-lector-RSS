const fs = require('fs');

// Create project structure
fs.mkdirSync('api', { recursive: true });

// Create PHP file
const phpContent = `<?php
header('Content-Type: application/json');
echo json_encode([
    'message' => 'Hello from serverless PHP!',
    'timestamp' => time()
]);
`;
fs.writeFileSync('api/index.php', phpContent);

// Create vercel.json
const vercelConfig = `{
  "functions": {
    "api/*.php": {
      "runtime": "vercel-php@0.6.0"
    }
  },
  "routes": [
    { "src": "/(.*)\\.php", "dest": "/api/index.php" }
  ]
}`;
fs.writeFileSync('vercel.json', vercelConfig);

// Create package.json
const packageJson = `{
  "name": "serverless-php",
  "version": "1.0.0",
  "scripts": {
    "build": "echo 'No build step required'"
  }
}`;
fs.writeFileSync('package.json', packageJson);

console.log('Project structure created successfully!');
console.log('Files created:');
console.log('- api/index.php');
console.log('- vercel.json');
console.log('- package.json');