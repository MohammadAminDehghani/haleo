import { apiClient } from '../api/client';
import { Todo } from '../types/todo.types';

class TodoService {
  async getAll(): Promise<Todo[]> {
    try {
      const response = await apiClient.get<Todo[]>('/todos');
      return response.data;
    } catch (error) {
      console.error('Error fetching todos:', error);
      throw error;
    }
  }

  async getById(id: number): Promise<Todo> {
    try {
      const response = await apiClient.get<Todo>(`/todos/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching todo ${id}:`, error);
      throw error;
    }
  }
}

export const todoService = new TodoService();

