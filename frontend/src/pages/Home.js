import React, { useEffect, useState } from "react";
import { getPosts, votePost , getPostVotes } from "../utils/api";
import { useNavigate } from "react-router-dom";
import "../styles.css";

function Home() {
  const [posts, setPosts] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchPosts = async () => {
      try {
        const data = await getPosts();
        if (Array.isArray(data)) {
          const updatedPosts = await Promise.all(
            data.map(async (post) => {
              const votes = await getPostVotes(post.PostId);
              return { ...post, votes };
            })
          );
          setPosts(updatedPosts);
        } else {
          console.error("Invalid posts data format:", data);
          setPosts([]);
        }
      } catch (error) {
        console.error("Error fetching posts:", error);
      }
    };
    fetchPosts();
  }, []);
  

  const handleVote = async (postId, voteType) => {
    try {
      const response = await votePost(postId, voteType);
  
      if (response.message === "Vote registered.") {
        const updatedVotes = await getPostVotes(postId);
  
        setPosts(posts.map(post => 
          post.PostId === postId ? { ...post, votes: updatedVotes } : post
        ));
      }
    } catch (error) {
      console.error("Error handling vote:", error);
    }
  };
  

  return (
    <div className="container">
      <h1 className="animated-text">Share and Explore Knowledge</h1>

      <h2>Recent Posts</h2>
      <div className="posts-container">
        {posts.length > 0 ? (
          posts.map((post) => (
            <div key={post.PostId} className="post-card">
              <h3>{post.Title}</h3>
              <p>
                {post.Description.length > 100 
                  ? post.Description.substring(0, 100) + "..." 
                  : post.Description}
              </p>
              <div className="post-footer">
                <button className="read-more-btn" onClick={() => navigate(`/post/${post.PostId}`)}>
                  Read More
                </button>
                
                <div className="vote-container">
                  <span className="vote-button" onClick={() => handleVote(post.PostId, "upvote")}>▲</span>
                  <span className="vote-count">{post.votes || 0}</span>
                  <span className="vote-button" onClick={() => handleVote(post.PostId, "downvote")}>▼</span>
                </div>
              </div>
            </div>
          ))
        ) : (
          <p>No posts available.</p>
        )}
      </div>
    </div>
  );
}

export default Home;