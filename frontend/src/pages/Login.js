import React, { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { loginUser } from "../utils/api";

function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();

    const response = await loginUser({ email, password });

    if (response.token && response.userId) {
      localStorage.setItem("token", response.token);
      localStorage.setItem("userId", response.userId);
      window.location.reload();
    } else {
      setError(response.message || "Invalid email or password.");
    }
  };

  return (
    <div className="form-container">
      <h2>Login</h2>
      {error && <p style={{ color: "red" }}>{error}</p>}
      <form onSubmit={handleLogin}>
        <input type="email" placeholder="Email" onChange={(e) => setEmail(e.target.value)} required />
        <input type="password" placeholder="Password" onChange={(e) => setPassword(e.target.value)} required />
        <button type="submit">Login</button>
      </form>
      <p>
        Don't have an account? <Link to="/register" style={{ color: "#007bff", fontWeight: "bold" }}>Register here</Link>
      </p>
    </div>
  );
}

export default Login;
