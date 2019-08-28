import { Nav, Navbar, NavItem } from "react-bootstrap";
import React, { Component } from 'react';
import { Button } from 'react-bootstrap';
import { Link } from "react-router-dom";
import { LinkContainer } from "react-router-bootstrap";

export default class NavBar extends Component {
  constructor(props){
    super(props);
  }

  render() {
  return (
      <Navbar inverse fluid>
        <Navbar.Header>
          <Navbar.Brand>
            <Link to="/">SCHMUCK </Link>
          </Navbar.Brand>
          <Navbar.Toggle />
        </Navbar.Header>
        <Navbar.Collapse>
          <Nav style={{display:"flex", flexDirection:"row"}}>
            <NavItem href="/login">Login</NavItem>
            <Button onClick={this.props.logoutUser}> Log Out</Button>
          </Nav>
          <Nav style={{display:"flex", flexDirection:"row"}} pullRight>
            <NavItem href="/absences">Absences</NavItem>
            <NavItem href="/tardies">Tardies/ED</NavItem>
            <NavItem href="/imports">Imports</NavItem>
          </Nav>
        </Navbar.Collapse>
      </Navbar>
  );
}
}
