import React, { Component } from 'react';
import axios from 'axios';
import { Checkbox } from 'react-bootstrap';


export default class TaskItem extends Component {
  constructor(props){
    super(props);
    this.state = {
      checked: false,
    };
    this.handleChange = this.handleChange.bind(this);
  }

  handleChange(e){
    this.setState({ checked: e.target.checked })
    if(e.target.checked){
      this.props.addStudent(this.props.student.id);
    }else{
      this.props.removeStudent(this.props.student.id);
    }
  }

   render() {
     const student = this.props.student;
    return (
      <Checkbox key={student.id} checked={this.state.checked} onChange={this.handleChange}>
      {student.student_id} ({student.event_count}) Language: {student.language}
      </Checkbox>
    );
  }
}
TaskItem.defaultProps = { student: [] };
