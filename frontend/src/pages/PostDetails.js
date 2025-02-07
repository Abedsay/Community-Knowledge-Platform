import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { getPostById, getComments, addComment, deleteComment } from "../utils/api";
import "../styles.css";

function PostDetails() {
  const { id } = useParams();
  const [post, setPost] = useState(null);
  const [comments, setComments] = useState([]);
  const [newComment, setNewComment] = useState("");
  const userId = localStorage.getItem("userId");

  useEffect(() => {
    const fetchData = async () => {
      try {
        const postDetails = await getPostById(id);
        const postComments = await getComments(id);
        setPost(postDetails[0]);
        setComments(postComments);
      } catch (error) {
        console.error("Error fetching post details:", error);
      }
    };
    fetchData();
  }, [id]);

  const handleAddComment = async () => {
    if (!newComment.trim()) return;

    const response = await addComment(id, userId, newComment);
    if (response.message === "Comment added successfully.") {
      const updatedComments = await getComments(id);
      setComments(updatedComments);
      setNewComment("");
    }
  };

  const handleDeleteComment = async (commentId) => {
    const response = await deleteComment(commentId);
    if (response.message === "Comment deleted successfully.") {
      setComments(comments.filter(comment => comment.CommentId !== commentId));
    }
  };

  if (!post) return <p className="loading-message">Loading post...</p>;

  return (
    <div className="post-details-container">
      <h1>{post.Title}</h1>
      <hr></hr>
      <p>{post.Description}</p>

      <div className="comment-section">
        <h3>Comments</h3>
        <textarea
          className="comment-input"
          placeholder="Write a comment..."
          value={newComment}
          onChange={(e) => setNewComment(e.target.value)}
        />
        <button className="comment-btn" onClick={handleAddComment}>Post Comment</button>

        <div className="comments-list">
          {comments.length > 0 ? (
            comments.map((comment) => (
              <div key={comment.CommentId} className="comment">
                <div className="comment-left">
                  <strong className="comment-username">{comment.Username || "Unknown User"}</strong>
                  <span className="comment-date">
                    {new Date(comment.CreatedAt).toLocaleDateString('en-US', {
                      month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'
                    })}
                  </span> 
                </div>

                <p className="comment-content">{comment.Content}</p>

                {comment.UserId == userId ? (
                  <button className="delete-comment-btn" onClick={() => handleDeleteComment(comment.CommentId)}>🗑</button>
                ) : (
                  <div className="delete-comment-btn"></div>
                )}
              </div>
            ))
          ) : (
            <p className="no-comments">No comments yet.</p>
          )}
        </div>
      </div>
    </div>
  );
}

export default PostDetails;
