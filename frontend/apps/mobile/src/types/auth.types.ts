import { User } from './user.types';

export interface LoginResponse {
  access_token: string;
  token_type: string;
  expires_at: string;
  user: User;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface RefreshTokenResponse {
  access_token: string;
  token_type: string;
  expires_at: string;
}

