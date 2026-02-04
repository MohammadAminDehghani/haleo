export interface Activity {
  id: number;
  name: string;
  description: string | null;
  type: string;
  user_id: number;
  created_at: string;
  updated_at: string;
}

