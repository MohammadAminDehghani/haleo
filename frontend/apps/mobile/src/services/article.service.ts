import { apiClient } from '../api/client';
import { Article } from '../types/article.types';

class ArticleService {
  async getAll(): Promise<Article[]> {
    try {
      const response = await apiClient.get<Article[]>('/articles');
      return response.data;
    } catch (error) {
      console.error('Error fetching articles:', error);
      throw error;
    }
  }

  async getById(id: number): Promise<Article> {
    try {
      const response = await apiClient.get<Article>(`/articles/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching article ${id}:`, error);
      throw error;
    }
  }
}

export const articleService = new ArticleService();

