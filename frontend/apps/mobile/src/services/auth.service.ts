import { apiClient } from '../api/client';
import { authStorage } from '../storage/auth.storage';
import type { LoginRequest, LoginResponse, RefreshTokenResponse } from '../types/auth.types';
import type { User } from '../types/user.types';

class AuthService {
  async login(credentials: LoginRequest): Promise<LoginResponse> {
    try {
      const response = await apiClient.post<LoginResponse>('/login', credentials);
      const data = response.data;

      // Store tokens
      await authStorage.saveAccessToken(data.access_token);
      if (data.user) {
        await authStorage.saveUser(data.user);
      }

      return data;
    } catch (error) {
      console.error('Error during login:', error);
      throw error;
    }
  }

  async logout(): Promise<void> {
    try {
      await apiClient.post('/logout');
    } catch (error) {
      console.error('Error during logout:', error);
    } finally {
      // Always clear local storage
      await authStorage.clear();
    }
  }

  async refreshToken(): Promise<RefreshTokenResponse> {
    try {
      const response = await apiClient.post<RefreshTokenResponse>('/refresh');
      const data = response.data;

      // Update stored token
      await authStorage.saveAccessToken(data.access_token);

      return data;
    } catch (error) {
      console.error('Error refreshing token:', error);
      // Clear storage on refresh failure
      await authStorage.clear();
      throw error;
    }
  }

  async getCurrentUser(): Promise<User> {
    try {
      const response = await apiClient.get<User>('/user');
      const user = response.data;

      // Update stored user
      await authStorage.saveUser(user);

      return user;
    } catch (error) {
      console.error('Error fetching current user:', error);
      throw error;
    }
  }

  async getStoredToken(): Promise<string | null> {
    return await authStorage.getAccessToken();
  }

  async clearStorage(): Promise<void> {
    await authStorage.clear();
  }
}

export const authService = new AuthService();

