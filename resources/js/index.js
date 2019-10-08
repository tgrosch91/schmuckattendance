import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Import from './components/Import';
import Login from './components/Login';
import Profile from './components/Profile';
import ImportList from './components/ImportList';
import Absences from './components/Absences';
import Tardies from './components/Tardies';
import ClassTardies from './components/ClassTardies';
import EarlyDismissals from './components/EarlyDismissals';
import Home from './components/Home';
import Register from './components/Register';
import NavBar from './components/NavBar';
import {BrowserRouter as Router, Link, Route, Redirect, Switch} from 'react-router-dom';

export default class Index extends Component {
  constructor(){
    super();
    this.state={
      isLoggedIn: false,
      user: {}
    }
  }

  componentDidMount() {
    let state = localStorage["appState"];
    if (state) {
      let AppState = JSON.parse(state);
      console.log(AppState);
      this.setState({ isLoggedIn: AppState.isLoggedIn, user: AppState });
    }
  }

  
  _registerUser = (name, email, password) => {
    $("#email-login-btn")
      .attr("disabled", "disabled")
      .html(
        '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span>'
      );
  
    var formData = new FormData();
    formData.append("password", password);
    formData.append("email", email);
    formData.append("name", name);
  
    axios
      .post("/api/user/register", formData)
      .then(response => {
        console.log(response);
        return response;
      })
      .then(json => {
        if (json.data.success) {
          alert(`Registration Successful!`);
  
          let userData = {
            name: json.data.data.name,
            id: json.data.data.id,
            email: json.data.data.email,
            auth_token: json.data.data.auth_token,
            timestamp: new Date().toString()
          };
          let appState = {
            isLoggedIn: true,
            user: userData
          };
          // save app state with user date in local storage
          localStorage["appState"] = JSON.stringify(appState);
          this.setState({
            isLoggedIn: appState.isLoggedIn,
            user: appState.user
          });
        } else {
          alert(`Registration Failed!`);
          $("#email-login-btn")
            .removeAttr("disabled")
            .html("Register");
        }
      })
      .catch(error => {
        alert("An Error Occured!" + error);
        console.log(`${formData} ${error}`);
        $("#email-login-btn")
          .removeAttr("disabled")
          .html("Register");
      });
  };

  _loginUser = (email, password) => {
    $("#login-form button")
      .attr("disabled", "disabled")
      .html(
        '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span>'
      );
    var formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    axios
      .post("/api/user/login/", formData)
      .then(response => {
        console.log(response);
        return response;
      })
      .then(json => {
        if (json.data.success) {
          alert("Login Successful!");

          let userData = {
            name: json.data.data.name,
            id: json.data.data.id,
            email: json.data.data.email,
            auth_token: json.data.data.auth_token,
            timestamp: new Date().toString()
          };
          console.log(json.data.data);
          let appState = {
            isLoggedIn: true,
            user: userData
          };
          // save app state with user date in local storage
          localStorage["appState"] = JSON.stringify(appState);
          this.setState({
            isLoggedIn: appState.isLoggedIn,
            user: appState.user
          });
        } else alert("Login Failed!");

        $("#login-form button")
          .removeAttr("disabled")
          .html("Login");
      })
      .catch(error => {
        alert(`An Error Occured! ${error}`);
        $("#login-form button")
          .removeAttr("disabled")
          .html("Login");
      });
  };


  _logoutUser = () => {
    let appState = {
      isLoggedIn: false,
      user: {}
    };
    // save app state with user date in local storage
    localStorage["appState"] = JSON.stringify(appState);
    this.setState(appState);
  };

    render() {
        return (
              <Router>
                <div>
                  <NavBar logoutUser={this._logoutUser}/>
                    <Route path="/login" exact render={(props) => <Login {...props} loginUser={this._loginUser} />}/>
                    {this.state.isLoggedIn &&
                      <div>
                    <Route path="/" exact component={Home}/>
                    <Route path="/absences" exact component={Absences}/>
                    <Route path="/tardies" exact component={Tardies}/>
                    <Route path="/class-tardies" exact component={ClassTardies} />
                    <Route path="/early-dismissals" exact component={EarlyDismissals} />
                    <Route path="/imports" exact component={ImportList}/>
                    <Route path="/student/:id" exact component={Profile}/>
                    </div>
                  }
                </div>
              </Router>
        );
    }
}

if (document.getElementById('base')) {
    ReactDOM.render(<Index />, document.getElementById('base'));
}
