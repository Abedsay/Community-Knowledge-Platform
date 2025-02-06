import axios from "axios";

const API_URL = "http://localhost/IDS/backend/api";

/**
 * Get all posts from the backend.
 */
export const getPosts = async () => {
  try {
    const response = await axios.get(`${API_URL}/posts.php`);
    return response.data;
  } catch (error) {
    console.error("Error fetching posts:", error);
    return [];
  }
};

/**
 * Get a single post by ID.
 */
export const getPostById = async (id) => {
  try {
    const response = await axios.get(`${API_URL}/posts.php?id=${id}`);
    console.log("API Response for Post Details:", response.data); // Debugging log
    if (!response.data || response.data.length === 0) {
      console.warn("No post data received!");
      return null;
    }
    return response.data;
  } catch (error) {
    console.error("Error fetching post:", error);
    return null;
  }
};


/**
 * Create a new post.
 */
export const createPost = async (postData) => {
  try {
    const token = localStorage.getItem("token");
    const response = await axios.post(`${API_URL}/posts.php`, postData, {
      headers: { Authorization: `Bearer ${token}` },
    });
    return response.data;
  } catch (error) {
    console.error("Error creating post:", error);
    return { message: "Failed to create post." };
  }
};

/**
 * Delete a post.
 */
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
    console.error("Error deleting post:", error);
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
    console.error("Error updating post:", error);
    return { message: "Failed to update post." };
  }
};

/**
 * Register a new user.
 */
export const registerUser = async (userData) => {
  try {
    console.log("Sending Register Request:", userData); // ✅ Debugging Log

    const response = await axios.post(`${API_URL}/users.php`, JSON.stringify(userData), {
      headers: { "Content-Type": "application/json" }
    });

    console.log("Register API Response:", response.data); // ✅ Debugging Log
    return response.data;
  } catch (error) {
    console.error("Error registering user:", error);
    return { message: "Failed to register." };
  }
};


/**
 * Log in a user.
 */
export const loginUser = async (credentials) => {
  try {
    const response = await axios.post(`${API_URL}/login.php`, credentials);
    console.log("API Login Response:", response.data); // Debugging log

    if (response.data.token) {
      localStorage.setItem("token", response.data.token);
      localStorage.setItem("userId", response.data.userId); // Store UserId properly
    }
    
    return response.data;
  } catch (error) {
    console.error("Error logging in:", error.response ? error.response.data : error.message);
    return { message: "Invalid login credentials." };
  }
};


/**
 * Get user profile data.
 */
// Fetch user profile details
export const getUserProfile = async () => {
  try {
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("userId"); // ✅ Retrieve stored UserId

    if (!userId) {
      console.error("❌ No userId found in localStorage");
      return null;
    }

    const response = await fetch(`${API_URL}/profile.php?userId=${userId}`, {
      headers: { Authorization: `Bearer ${token}` }
    });

    const data = await response.json();
    console.log("✅ API Response for Profile:", data); // Debugging log
    return data;
  } catch (error) {
    console.error("❌ Error fetching user profile:", error);
    return null;
  }
};


// Fetch posts created by the user
export const getUserPosts = async () => {
  try {
    const token = localStorage.getItem("token");
    const userId = localStorage.getItem("userId"); // ✅ Retrieve stored UserId

    if (!userId) {
      console.error("❌ No userId found in localStorage");
      return [];
    }

    const response = await fetch(`${API_URL}/user_posts.php?userId=${userId}`, {
      headers: { Authorization: `Bearer ${token}` }
    });

    const data = await response.json();
    console.log("✅ API Response for User Posts:", data); // Debugging log
    return data;
  } catch (error) {
    console.error("❌ Error fetching user posts:", error);
    return [];
  }
};


/**
 * Vote on a post (upvote/downvote).
 */
/**
 * Fetch total votes for a post.
 */
export const getPostVotes = async (postId) => {
  try {
    const response = await axios.get(`${API_URL}/votes.php?postId=${postId}`);
    return response.data.votes;
  } catch (error) {
    console.error("Error fetching votes:", error);
    return 0;
  }
};


/**
 * Submit a vote (upvote/downvote).
 */
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
    console.error("Error voting on post:", error);
    return { message: "Failed to vote." };
  }
};
