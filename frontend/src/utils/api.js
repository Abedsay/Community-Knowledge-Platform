import axios from "axios";

const API_URL = "http://localhost/IDS/backend/api";

export const getPosts = async () => {
  try {
    const response = await axios.get(`${API_URL}/posts.php`);
    return response.data;
  } catch (error) {
    return [];
  }
};

export const getPostById = async (id) => {
  try {
    const response = await axios.get(`${API_URL}/posts.php?id=${id}`);
    if (!response.data || response.data.length === 0) {
      return null;
    }
    return response.data;
  } catch (error) {
    return null;
  }
};

export const createPost = async (postData) => {
  try {
    const token = localStorage.getItem("token");
    const response = await axios.post(`${API_URL}/posts.php`, postData, {
      headers: { Authorization: `Bearer ${token}` },
    });
    return response.data;
  } catch (error) {
    return { message: "Failed to create post." };
  }
};

export const deletePost = async (postId) => {
  try {
    const token = localStorage.getItem("token");
    const response = await fetch(`${API_URL}/posts.php`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify({ PostId: postId }),
    });
    return await response.json();
  } catch (error) {
    return { message: "Failed to delete post." };
  }
};

export const updatePost = async (postData) => {
  try {
    const token = localStorage.getItem("token");
    const response = await fetch(`${API_URL}/posts.php`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify(postData),
    });
    return await response.json();
  } catch (error) {
    return { message: "Failed to update post." };
  }
};

export const registerUser = async (userData) => {
  try {
    const response = await axios.post(`${API_URL}/users.php`, JSON.stringify(userData), {
      headers: { "Content-Type": "application/json" },
    });
    return response.data;
  } catch (error) {
    return { message: "Failed to register." };
  }
};

export const loginUser = async (credentials) => {
  try {
    const response = await axios.post(`${API_URL}/login.php`, credentials);
    if (response.data.token) {
      localStorage.setItem("token", response.data.token);
      localStorage.setItem("userId", response.data.userId);
    }
    return response.data;
  } catch (error) {
    return { message: "Invalid login credentials." };
  }
};

export const getUserProfile = async () => {
  try {
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("userId");
    if (!userId) return null;

    const response = await fetch(`${API_URL}/profile.php?userId=${userId}`, {
      headers: { Authorization: `Bearer ${token}` },
    });

    return await response.json();
  } catch (error) {
    return null;
  }
};

export const getUserPosts = async () => {
  try {
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("userId");
    if (!userId) return [];

    const response = await fetch(`${API_URL}/user_posts.php?userId=${userId}`, {
      headers: { Authorization: `Bearer ${token}` },
    });

    return await response.json();
  } catch (error) {
    return [];
  }
};

export const getPostVotes = async (postId) => {
  try {
    const response = await axios.get(`${API_URL}/votes.php?postId=${postId}`);
    return response.data.votes;
  } catch (error) {
    return 0;
  }
};

export const votePost = async (postId, voteType) => {
  try {
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("userId");
    const response = await axios.post(
      `${API_URL}/votes.php`,
      { UserId: userId, PostId: postId, VoteType: voteType },
      { headers: { Authorization: `Bearer ${token}` } }
    );
    return response.data;
  } catch (error) {
    return { message: "Failed to vote." };
  }
};

export const getComments = async (postId) => {
  try {
    const response = await axios.get(`${API_URL}/comments.php?postId=${postId}`);
    return response.data;
  } catch (error) {
    return [];
  }
};

export const addComment = async (postId, userId, content) => {
  try {
    const response = await axios.post(`${API_URL}/comments.php`, {
      PostId: postId,
      UserId: userId,
      Content: content,
    });
    return response.data;
  } catch (error) {
    return { message: "Failed to add comment." };
  }
};

export const deleteComment = async (commentId) => {
  try {
    const response = await axios.delete(`${API_URL}/comments.php`, {
      data: { CommentId: commentId },
    });
    return response.data;
  } catch (error) {
    return { message: "Failed to delete comment." };
  }
};
