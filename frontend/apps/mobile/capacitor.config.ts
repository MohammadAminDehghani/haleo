import type { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'com.haleo.app',
  appName: 'haleo',
  webDir: '../../dist/apps/mobile'  // Update to match Nx build output
};

export default config;
