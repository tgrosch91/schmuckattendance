import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {Jumbotron,Button } from 'react-bootstrap';
import Select from 'react-select';
import Import from './Import';
import TaskList from './TaskList';
import axios from "axios";

const styles = {
  fontFamily: "sans-serif",
  textAlign: "center"
};

export default class Home extends Component {
  constructor(props){
    super(props);
    console.log(JSON.parse(localStorage["appState"]));
    this.state={
      selectedOption: null,
      isLoggedIn: false,
      students: [],
      token: JSON.parse(localStorage["appState"]).user.auth_token,
      users: []
    }
    this.handleChange = this.handleChange.bind(this);
    this.selectLetterType = this.selectLetterType.bind(this);
  }

  componentDidMount() {
    axios
      .get(`/api/users/list?token=${this.state.token}`)
      .then(response => {
        console.log(response);
        return response;
      })
      .then(json => {
        if (json.data.success) {
          this.setState({ users: json.data.data, isLoggedIn: true });
          //alert("Login Successful!");
        } else alert("Login Failed!");
      })
      .catch(error => {
        this.setState({ isLoggedIn: false });
      });
  }

  handleChange = (selectedOption) => {
    this.setState({ selectedOption: selectedOption });
    axios.get(`/api/task/${selectedOption.value}`).then((response) => {
      this.setState({
        students: response.data
      });
    }).catch(errors =>{
      console.log(errors);
    })
    console.log(`Option selected:`, selectedOption);
  }

  selectLetterType(selectedOption){
    axios.get(`/api/task/${selectedOption.value}`).then((response) => {
      this.setState({
        students: response.data
      });
    }).catch(errors =>{
      console.log(errors);
    })
  }

  render() {
    const options = [
      { value: 1, label: '3 Absences' },
      { value: 2, label: '5 Absences' },
      { value: 3, label: '7 Absences' },
      { value: 4, label: '10 Absences' },
      { value: 5, label: '5 Tardies/Early Dismissals' },
      { value: 6, label: '10 Tardies/Early Dismissals' },
      { value: 7, label: '15 Tardies/Early Dismissals' },
      { value: 8, label: '3 Consecutive Absences' },
      { value: 9, label: '10 Consecutive Absences' }
    ];
        return (
            <div className="container">
            {this.state.isLoggedIn &&
              <div>
                <Jumbotron>
                  <h1>S*C*H*M*U*C*K</h1>
                  <h4>*STUDENTS*CIRCUMVENTING*HIGHSCHOOL*MISTAKENLY*</h4>
                  <h4>*UNDERESTIMATE*COUNSELOR'S*KICKASSNESS*</h4>
                  <p>Welcome to your very own attendance app! To get started,
                  record a new day's worth of delinquents by clicking the import
                  button below and attaching your CSV file. To see who needs to
                  be sent a letter, choose the letter type in the dropdown below.
                  Love you forever!</p>
                </Jumbotron>
                <Import/>
                <div>
                <Select
                  value={this.state.selectedOption}
                  onChange={this.handleChange}
                  options={options}
                />
                { this.state.selectedOption &&
                  <TaskList refreshStudents={this.selectLetterType} type={this.state.selectedOption} students= {this.state.students}/>
                }
                </div>
              </div>
            }
          </div>
        );
    }
}
