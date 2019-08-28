
import React from "react";
import { Link } from "react-router-dom";

const Register = ({ history, registerUser = f => f }) => {
    let _email, _password, _name;

    const handleLogin = e => {
        e.preventDefault();

        registerUser(_name.value, _email.value, _password.value);
    };
    return (
        <div id="main">
            <form id="login-form" action="" onSubmit={handleLogin} method="post">
                <h3 style={{ padding: 15 }}>If you're not schmuck, don't bother.</h3>
                <input ref={input => (_name = input)} autoComplete="off" id="name-input" name="name" type="text" className="center-block" placeholder="Name" />
                <input ref={input => (_email = input)} autoComplete="off" id="email-input" name="email" type="text" className="center-block" placeholder="email" />
                <input ref={input => (_password = input)} autoComplete="off" id="password-input" name="password" type="password" className="center-block" placeholder="password" />
                <button type="submit" className="landing-page-btn center-block text-center" id="email-login-btn" href="#facebook" >
                    Register
        </button>
            </form>
        </div>
    );
};

export default Register;