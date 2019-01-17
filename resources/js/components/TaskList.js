import React, { Component } from 'react';
import axios from 'axios';
import TaskItem from './TaskItem';
import { FormGroup, Button } from 'react-bootstrap';

export default class TaskList extends Component {
  constructor(props){
    super(props);
    this.state = {
      selectedStudents: []
    };
    this.addStudent = this.addStudent.bind(this);
    this.removeStudent = this.removeStudent.bind(this);
    this.submitStudentLetters = this.submitStudentLetters.bind(this);
  }
  submitStudentLetters(){
    axios.get('/api/task/complete',{
      params: {
        students: this.state.selectedStudents,
        letter: this.props.type.value
      }
    }).then((response) => {
      this.props.refreshStudents(this.props.type);
      console.log(response);
      // after this use a callback function to tell parent function to reload this particular task list
    }).catch(errors =>{
      console.log(errors);
    })
    console.log(`Students selected:`, this.state.selectedStudents);
  }

  addStudent(id){
    this.setState({
      selectedStudents: [...this.state.selectedStudents, id]
    })
  }

  removeStudent(id){
    var array = this.state.selectedStudents.filter(function(student) {
     return student !== id
   });
   this.setState({
     selectedStudents: array
   })
  }

  getStudentList(students){
    if(students.length){
      let items = students.map(student => {
        return (
          <TaskItem addStudent={this.addStudent} removeStudent={this.removeStudent} student={student}/>
        )
      });
      return items;
    }else{
      return (<div>No students need to receive this letter</div>);
    }
  };
  // Take each student that is given, and knowing the type prop send that
  // through to mark that particular letter type as sent

   render() {
    return (
      <div>
      <h5>{this.props.title}</h5>
      <FormGroup>
      {this.getStudentList(this.props.students)}
      </FormGroup>
      <Button onClick={this.submitStudentLetters} bsStyle="primary">Update</Button>
      </div>
    );
  }
}
TaskList.defaultProps = { students: [] };
