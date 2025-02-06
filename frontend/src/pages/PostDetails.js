import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { getPostById } from "../utils/api";
import "../styles.css";

function PostDetails() {
  const { id } = useParams();
  const [post, setPost] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchPost = async () => {
      try {
        const data = await getPostById(id);
        console.log("Fetched Post Details:", data); // Debugging log

        if (Array.isArray(data) && data.length > 0) {
          setPost(data[0]); // Extract first item from array
        } else {
          setError("Post not found.");
        }
      } catch (err) {
        setError("Failed to load post. Please try again later.");
      } finally {
        setLoading(false);
      }
    };
    fetchPost();
  }, [id]);

  if (loading) return <p>Loading post...</p>;
  if (error) return <p className="error-message">{error}</p>;

  return (
    <div className="container post-details">
      <h1>{post.Title}</h1>
      <hr></hr>
      <p>{post.Description}</p>
    </div>
  );
}

export default PostDetails;
