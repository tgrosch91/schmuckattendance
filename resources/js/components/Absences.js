import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import FilterableTable from 'react-filterable-table';
import axios from 'axios';
import {Link} from 'react-router-dom';
import { Popover, OverlayTrigger } from 'react-bootstrap';

export default class Absences extends Component {
  constructor(){
    super();
    this.state={
      students: []
    }
    this.getCount = this.getCount.bind(this);
    this.getLetterInfo = this.getLetterInfo.bind(this);
    this.getLetterCount = this.getLetterCount.bind(this);
    this.getEventDates = this.getEventDates.bind(this);
    this.getEditLink = this.getEditLink.bind(this);
  }
  componentWillMount(){
    axios.get('/api/student/absences').then((response) => {
      this.setState({
        students: response.data
      });
    }).catch(errors =>{
      console.log(errors);
    })
  }
  getEventDates(events){
    let dates = events.map(event => {
      return (
        <li key = {event.id}>
          {event.event_date}
        </li>
      )
    });
    return dates;
  };
  getCount(props){
    let title = "Absent Dates (" + props.record.student_id + ")";
    const popover = (
          <Popover id="popover-trigger-click" title={title}>
            {this.getEventDates(props.record.event)}
          </Popover>
        );
    return (
      <OverlayTrigger
      trigger="click"
      placement="right"
      overlay = {popover}>
        <a style={{color:'blue'}}>
          {props.record.count}
        </a>
      </OverlayTrigger>
    ) ;
  }

  getLetterInfo(letters){
    let info = letters.map(letter => {
      return (
        <li key = {letter.id}>
          {letter.name}
        </li>
      )
    });
    return info;
  };

  getLetterCount(props){
    let title = "Letters Sent (" + props.record.student_id + ")";
    const popover = (
          <Popover id="popover-trigger-click" title={title}>
            {this.getLetterInfo(props.record.letters)}
          </Popover>
        );
    if(props.record.letter_count === '-0-'){
      return <div>-0-</div>;
    }
    return (
      <OverlayTrigger
      trigger="click"
      placement="right"
      overlay = {popover}>
        <a style={{color:'blue'}}>
          {props.record.letter_count}
        </a>
      </OverlayTrigger>
    ) ;
  }

  getEditLink(props){
    return (
      <Link to={"/student/" + props.record.id} > Edit </Link>
    ) ;
  }

    render() {
      const fields = [
          { name: 'student_id', displayName: "Student Id", inputFilterable: true, sortable: true },
          { name: 'grade', displayName: "Grade", inputFilterable: true, exactFilterable: true, sortable: true },
          { name: 'count', displayName: "Absences", inputFilterable: true, exactFilterable: false, sortable: true, render: this.getCount },
          { name: 'letter_count', displayName: "Letters Sent", inputFilterable: true, exactFilterable: false, sortable: true, render: this.getLetterCount },
          { name: 'edit', displayName: "", inputFilterable: false, exactFilterable: false, sortable: false, render: this.getEditLink }
      ];
      const data = this.state.students;
        return (
            <div className="container" >
            <FilterableTable
              namespace="Student Absences"
              initialSort="student_id"
              data={data}
              fields={fields}
              noRecordsMessage="There are no students to display"
              noFilteredRecordsMessage="No students match your filters!"
            />
            </div>
        );
    }
}
