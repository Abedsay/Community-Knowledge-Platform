import React, { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { registerUser } from "../utils/api";
import "./../styles.css";

function Register() {
  const [username, setUsername] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleRegister = async () => {
    const userData = {
      username,
      email,
      password,
      roleId: 2  // Default role (e.g., 2 = regular user, 1 = admin)
    };
  
    console.log("Submitting user data:", userData);  // ✅ Debugging Log
  
    const response = await registerUser(userData);
    console.log("API Response:", response);  // ✅ Debugging Log
  
    if (response.message === "User created successfully.") {
      navigate("/login");
    } else {
      setError(response.message);
    }
  };
  

  return (
    <div className="form-container">
      <h2>Register</h2>
      {error && <p style={{ color: "red" }}>{error}</p>}
      <form onSubmit={(e) => { e.preventDefault(); handleRegister(); }}>
        <input type="text" placeholder="Username" value={username} onChange={(e) => setUsername(e.target.value)} required />
        <input type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} required />
        <input type="password" placeholder="Password" value={password} onChange={(e) => setPassword(e.target.value)} required />
        <button type="submit">Register</button>
      </form>
      <p>
        Already have an account? <Link to="/login" className="link-text">Login here</Link>
      </p>
    </div>
  );
}

export default Register;
