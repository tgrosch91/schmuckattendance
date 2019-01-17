import React, { Component } from 'react';
import axios from 'axios';
import Select from 'react-select';
import { Button } from 'react-bootstrap';
import Letter from './Letter';
import Event from './Event';

export default class Profile extends Component {
  constructor(props){
    super(props);
    this.state={
      student: [],
      selectedGrade: null,
      language: '',
      updateMessage: ''
    }
    this.handleGradeChange = this.handleGradeChange.bind(this);
    this.deleteEvent = this.deleteEvent.bind(this);
    this.deleteLetter = this.deleteLetter.bind(this);
    this.handleLanguageChange = this.handleLanguageChange.bind(this);
  }
  componentWillMount(){
    const id = this.props.match.params.id;
    axios.get(`/api/student/${id}`).then((response) => {
      this.setState({
        student: response.data,
        selectedGrade: response.data.grade,
        language: response.data.language
      });
    }).catch(errors =>{
      console.log(errors);
    })
  }
  updateStudentInfo(e,id){
    e.preventDefault();
    let url = '/api/student/'+id;
    axios.put(url,{
      params: {
        grade: this.state.selectedGrade,
        language: this.state.language
      }
    }).then((response) => {
      axios.get(`/api/student/${this.state.student.id}`).then((response) => {
        this.setState({
          student: response.data,
          selectedGrade: response.data.grade,
          language: response.data.language
        });
      }).catch(errors =>{
        console.log(errors);
      })
    }).catch(errors =>{
      this.setState({ updateMessage: 'Error saving' });
      console.log(errors);
    })
  }

  handleGradeChange(selectedOption){
    this.setState({ selectedGrade: selectedOption.value });
  }

  handleLanguageChange(e){
    this.setState({ language: e.target.value });
  }
  deleteEvent(id){
    console.log(id);
    axios.get('/api/student/delete_event',{
      params: {
        studentId: this.state.student.id,
        event: id
      }
    }).then((response) => {
      axios.get(`/api/student/${this.state.student.id}`).then((response) => {
        this.setState({
          student: response.data,
          selectedGrade: response.data.grade,
          language: response.data.language
        });
      }).catch(errors =>{
        console.log(errors);
      })
    }).catch(errors =>{
      console.log(errors);
    })
  }

  getEvents(events){
    if(events && events.length){
      let items = events.map(event => {
        return (
          <Event deleteEvent={this.deleteEvent} event={event}/>
        )
      });
      return items;
    }else{
      return (<div>No events found for this student</div>);
    }
  }
  deleteLetter(id){
    console.log(id);
    axios.get('/api/student/delete_letter',{
      params: {
        studentId: this.state.student.id,
        letter: id
      }
    }).then((response) => {
      axios.get(`/api/student/${id}`).then((response) => {
        this.setState({
          student: response.data,
          selectedGrade: response.data.grade,
          language: response.data.language
        });
      }).catch(errors =>{
        console.log(errors);
      })
    }).catch(errors =>{
      console.log(errors);
    })
  }
  getLetters(letters){
    if(letters && letters.length){
      let items = letters.map(letter => {
        return (
          <Letter deleteLetter={this.deleteLetter} letter={letter}/>
        )
      });
      return items;
    }else{
      return (<div>No letters found for this student</div>);
    }
  }
    render() {

      const student = this.state.student;
      const gradeOptions = [
      { value: 9, label: '9' },
      { value: 10, label: '10' },
      { value: 11, label: '11' },
      { value: 12, label: '12' },
    ];
        return (
            <div className="container" >
              <h2>{student.student_id} Profile</h2>
              <h4>Information</h4>
              <div>
                <div>Grade:
                  <Select
                    value={this.state.selectedGrade}
                    placeholder={this.state.selectedGrade}
                    onChange={this.handleGradeChange}
                    options={gradeOptions}
                  />
                </div>
                <div>Language:
                  <input type="text" value={this.state.language} onChange={this.handleLanguageChange}/>
                </div>
                <Button onClick={(evt) => this.updateStudentInfo(evt, student.id)}>UPDATE</Button>
                {this.state.updateMessage}
              </div>
              <h4>Events</h4>
              <div>{this.getEvents(this.state.student.event)}</div>
              <h4>Letters</h4>
              <div>{this.getLetters(this.state.student.letters)}</div>
            </div>
        );
    }
}
