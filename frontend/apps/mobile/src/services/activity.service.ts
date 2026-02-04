import { apiClient } from '../api/client';
import { Activity } from '../types/activity.types';

class ActivityService {
  async getAll(): Promise<Activity[]> {
    try {
      const response = await apiClient.get<Activity[]>('/activities');
      return response.data;
    } catch (error) {
      console.error('Error fetching activities:', error);
      throw error;
    }
  }

  async getById(id: number): Promise<Activity> {
    try {
      const response = await apiClient.get<Activity>(`/activities/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching activity ${id}:`, error);
      throw error;
    }
  }
}

export const activityService = new ActivityService();

