import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { getPostById, updatePost } from "../utils/api";
import "../styles.css";

function EditPost() {
  const { id } = useParams();
  const navigate = useNavigate();

  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");

  useEffect(() => {
    const fetchPost = async () => {
      const postData = await getPostById(id);
      if (postData) {
        setTitle(postData.Title);
        setDescription(postData.Description);
      } else {
        alert("Failed to fetch post.");
        navigate("/profile");
      }
    };

    fetchPost();
  }, [id, navigate]);

  const handleUpdate = async (e) => {
    e.preventDefault();
    const response = await updatePost({ PostId: id, Title: title, Description: description });
    if (response.message === "Post updated successfully.") {
      navigate("/profile");
    } else {
      alert("Failed to update post.");
    }
  };

  return (
    <div className="form-container">
      <h2>Edit Post</h2>
      <form onSubmit={handleUpdate}>
        <input type="text" placeholder="Title" value={title} onChange={(e) => setTitle(e.target.value)} required />
        <textarea placeholder="Description" value={description} onChange={(e) => setDescription(e.target.value)} required />
        <button type="submit">Update Post</button>
      </form>
    </div>
  );
}

export default EditPost;
