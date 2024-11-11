import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';

export default defineConfig({
    server: {
        host: '192.168.1.12',
        port: 5174,
        https: {
            key: fs.readFileSync('C:/Users/Administrator/Desktop/Capstone/version_one-master/server.key'),
            cert: fs.readFileSync('C:/Users/Administrator/Desktop/Capstone/version_one-master/server.crt'),
        },
    },
    plugins: [vue()],
});