import React, { useState, useEffect } from "react";
import { createPost } from "../utils/api";
import { useNavigate } from "react-router-dom";
import "./../styles.css";

function CreatePost() {
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const navigate = useNavigate();

  useEffect(() => {
    const userId = localStorage.getItem("userId");
    if (!userId) {
      alert("You must be logged in to create a post.");
      navigate("/login");
    }
  }, [navigate]);

  const handleSubmit = async (e) => {
    e.preventDefault();

    const userId = localStorage.getItem("userId");
    if (!userId) {
      alert("You must be logged in to create a post.");
      return;
    }

    const postData = { 
      Title: title, 
      Description: description, 
      UserId: userId  
    };

    const response = await createPost(postData);

    if (response.message === "Post created successfully.") {
      navigate("/");
    } else {
      alert("Failed to create post.");
    }
  };

  return (
    <div className="form-container">
      <h2>Create a New Post</h2>
      <form onSubmit={handleSubmit}>
        <input type="text" placeholder="Enter Post Title" value={title} onChange={(e) => setTitle(e.target.value)} required />
        <textarea placeholder="Describe your post..." value={description} onChange={(e) => setDescription(e.target.value)} required />
        <button type="submit">Submit</button>
      </form>
    </div>
  );
}

export default CreatePost;
