#!/usr/bin/env node
import { context } from 'esbuild';

const ctx = await context({
  bundle: true,
  color: true,
  entryPoints: ['resources/ts/components/geocoder.ts'],
  format: 'esm',
  mainFields: ['module', 'main'],
  minify: true,
  outfile: './dist/mapbox.js',
  platform: 'browser',
  target: ['es2020'],
  treeShaking: true,
  plugins: [
    {
      name: 'watcher',
      setup(build) {
        build.onStart(() => {
          const outfile = build.initialOptions.outfile;
          const now = new Date(Date.now()).toLocaleTimeString();

          console.log(`⏱️ Build started at ${now}: ${outfile}`);
        });

        build.onEnd(result => {
          const outfile = build.initialOptions.outfile;
          const now = new Date(Date.now()).toLocaleTimeString();

          if (result.errors.length > 0) {
            return console.error(`🚫 Build failed at ${now}: ${outfile}`);
          }

          console.log(`✅  Build finished at ${now}: ${outfile}`);
        });
      }
    }
  ]
});

if (process.argv.includes('--watch')) {
  await ctx.watch();
} else {
  await ctx.rebuild();
  await ctx.dispose();
}
