# CMC Theme

## Getting the Default Theme

Clone this repository and install its dependencies:

```bash
git clone git@git.mcontigo.com:wordpress/cmc-theme.git
cd cmc-theme
npm install
```

## Starting Development

Inside the folder where *packages.json* is located, run the command
```bash
npm run watch
```
To start the resources watcher/compiler.
As long as it is active, every time you save some .js or .css file inside the /assets folder it will automatically recompile the code.

## Compiling for production

Inside the folder where *packages.json* is located, run the command
```bash
npm run prod
```
Your code inside the /assets folder will compile to production with minification.