const fs = require('fs');
const path = require('path');

function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(function(file) {
        file = path.join(dir, file);
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walk(file));
        } else { 
            results.push(file);
        }
    });
    return results;
}

const templatesDir = path.join(__dirname, 'templates');
const baseTemplate = path.join(templatesDir, 'base.html.twig');
const files = walk(templatesDir);

for (const file of files) {
    if (!file.endsWith('.twig') || file === baseTemplate) continue;

    let content = fs.readFileSync(file, 'utf8');
    let originalContent = content;
    
    // 1. Remove ANY <nav> block
    content = content.replace(/<nav>[\s\S]*?<\/nav>\s*/g, '');
    
    // 2. Remove ANY .page-nav block
    content = content.replace(/<div class="page-nav">[\s\S]*?<\/div>(\s*<br>)*\s*/g, '');
    
    // Clean up empty lines at the start, properly format the extends block
    content = content.trimStart();
    content = content.replace(/^({% extends .*? %})\s*/, "$1\n\n");

    if (content !== originalContent) {
        fs.writeFileSync(file, content);
        console.log(`Fixed: ${file}`);
    }
}
console.log('Done cleaning child templates.');
