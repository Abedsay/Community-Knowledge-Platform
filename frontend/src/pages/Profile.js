import React, { useEffect, useState } from "react";
import { getUserProfile, getUserPosts, deletePost } from "../utils/api";
import "../styles.css";
import { useNavigate } from "react-router-dom";
import { getPosts, getPostVotes } from "../utils/api"; 

function Profile() {
  const [user, setUser] = useState(null);
  const [posts, setPosts] = useState([]);
  const navigate = useNavigate();

  const handleEdit = (post) => { 
    navigate(`/edit/${post.PostId}`);
  };

  useEffect(() => {
    const fetchProfile = async () => {
      try {
        const userData = await getUserProfile();
        let userPosts = await getUserPosts();
  
        userPosts = await Promise.all(
          userPosts.map(async (post) => {
            const votes = await getPostVotes(post.PostId);
            return { ...post, votes };
          })
        );
  
        setUser(userData);
        setPosts(userPosts);
      } catch (error) {
        console.error("Error fetching profile:", error);
      }
    };
  
    fetchProfile();
  }, []);
  

  const handleDelete = async (postId) => {
    if (window.confirm("Are you sure you want to delete this post?")) {
      const response = await deletePost(postId);
      if (response.message === "Post deleted successfully.") {
        setPosts(posts.filter(post => post.PostId !== postId)); 
      } else {
        alert("Failed to delete post.");
      }
    }
  };

  if (!user) return <p>Loading profile...</p>;

  return (
    <div className="profile-container">
      <h1>{user.username}</h1>
      <h2>My Posts</h2>
      <div className="posts-grid">
        {posts.length > 0 ? (
          posts.map((post) => (
            <div key={post.PostId} className="post-card">
              <h3>{post.Title}</h3>
              <p>{post.Description.length > 100 ? post.Description.substring(0, 100) + "..." : post.Description}</p>
              
              <div className="vote-count-profile">Votes: {post.votes || 0}</div>

              <div className="post-actions">
                <button className="edit-btn" onClick={() => handleEdit(post)}>✏ Edit</button>
                <button className="delete-btn" onClick={() => handleDelete(post.PostId)}>🗑 Delete</button>
              </div>
            </div>
          ))
        ) : (
          <p>No posts yet.</p>
        )}
      </div>
    </div>
  );
}

export default Profile;