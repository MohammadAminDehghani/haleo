import { Preferences } from '@capacitor/preferences';

const ACCESS_TOKEN_KEY = 'auth_access_token';
const REFRESH_TOKEN_KEY = 'auth_refresh_token';
const USER_KEY = 'auth_user';

class AuthStorage {
  /**
   * Save access token to secure storage
   */
  async saveAccessToken(token: string): Promise<void> {
    await Preferences.set({
      key: ACCESS_TOKEN_KEY,
      value: token,
    });
  }

  /**
   * Get access token from secure storage
   */
  async getAccessToken(): Promise<string | null> {
    const result = await Preferences.get({ key: ACCESS_TOKEN_KEY });
    return result.value || null;
  }

  /**
   * Save refresh token to secure storage
   */
  async saveRefreshToken(token: string): Promise<void> {
    await Preferences.set({
      key: REFRESH_TOKEN_KEY,
      value: token,
    });
  }

  /**
   * Get refresh token from secure storage
   */
  async getRefreshToken(): Promise<string | null> {
    const result = await Preferences.get({ key: REFRESH_TOKEN_KEY });
    return result.value || null;
  }

  /**
   * Save user data to storage
   */
  async saveUser(user: unknown): Promise<void> {
    await Preferences.set({
      key: USER_KEY,
      value: JSON.stringify(user),
    });
  }

  /**
   * Get user data from storage
   */
  async getUser(): Promise<unknown | null> {
    const result = await Preferences.get({ key: USER_KEY });
    if (!result.value) return null;
    try {
      return JSON.parse(result.value);
    } catch {
      return null;
    }
  }

  /**
   * Remove all auth data from storage
   */
  async clear(): Promise<void> {
    await Promise.all([
      Preferences.remove({ key: ACCESS_TOKEN_KEY }),
      Preferences.remove({ key: REFRESH_TOKEN_KEY }),
      Preferences.remove({ key: USER_KEY }),
    ]);
  }
}

export const authStorage = new AuthStorage();

