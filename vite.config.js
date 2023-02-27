import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
const fetch = import('node-fetch');

const getColorFromDB = async () => {
  const response = await fetch('https://quynhnhu.test/getThemeColor');
  const data = await response.json();
  return data.colors;
  // try {
  //   const response = await fetch('https://quynhnhu.test/getThemeColor');
  //   const data = await response.json();
  //   return data.colors;
  // } catch (error) {
  //   console.error(error);
  // }
};

/* export style */
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sources/main/style.scss', 
                'resources/sources/admin/style.scss'
            ],
            refresh: true,
            transform: async (code, id) => {
                if (id.endsWith('.scss')) {
                  const color = await getColorFromDB();
                  code = code.replace(/@colorLv1:\s*#[0-9a-fA-F]+;/, `@colorLv1: ${color};`);
                }
                return code;
              },
        }),
    ]
});

