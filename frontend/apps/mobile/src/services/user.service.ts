import { apiClient } from '../api/client';
import { User } from '../types/user.types';

class UserService {
  async getProfile(id: number = 1): Promise<User> {
    try {
      const response = await apiClient.get<User>(`/users/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching user profile ${id}:`, error);
      throw error;
    }
  }
}

export const userService = new UserService();
