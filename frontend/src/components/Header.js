import React, { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import "../styles.css";

function Header() {
  const navigate = useNavigate();
  const [loggedIn, setLoggedIn] = useState(!!localStorage.getItem("token")); 

  useEffect(() => {
    const checkLogin = () => {
      setLoggedIn(!!localStorage.getItem("token"));
    };
    
    window.addEventListener("storage", checkLogin); 
    return () => window.removeEventListener("storage", checkLogin);
  }, []);

  const handleLogout = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("userId");
    setLoggedIn(false); 
    navigate("/login");
  };

  return (
    <header className="header">
      <div className="logo">Community Platform</div>
      <nav>
        <ul className="nav-links">
          <li><Link to="/">Home</Link></li>
          <li><Link to="/create">Create Post</Link></li>
          {loggedIn ? (
            <>
              <li><Link to="/profile">Profile</Link></li>
              <li><button onClick={handleLogout} className="logout-btn">Logout</button></li>
            </>
          ) : (
            <li><Link to="/login">Login</Link></li>
          )}
        </ul>
      </nav>
    </header>
  );
}

export default Header;
