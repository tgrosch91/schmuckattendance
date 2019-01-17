import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { Button } from 'react-bootstrap';

export default class Event extends Component {
  constructor(props){
    super(props);
  }

  deleteEvent(e,id){
    e.preventDefault();
    this.props.deleteEvent(id)
  }

    render() {
      const event = this.props.event;
      let label = this.props.event.event_type_id === 1 ? 'Absence' : 'Tardy/ED';
        return (
          <div key={event.id}>
            <li>{label} {event.event_date} <Button onClick={(evt) => this.deleteEvent(evt, event.id)}>DELETE</Button> </li>
          </div>
        );
    }
}
