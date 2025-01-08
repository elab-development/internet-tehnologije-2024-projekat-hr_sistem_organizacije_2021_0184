
import React from 'react';
import {Container, Nav, Navbar} from "react-bootstrap";

const Navigacija = () => {

    const user = JSON.parse(window.sessionStorage.getItem('user'));
    const token = window.sessionStorage.getItem('token');

    const ulogovan = token !== null;
    const admin = ulogovan && user.ulogaUSistemu === 'admin';

    const odjaviSe = () => {
        window.sessionStorage.removeItem('token');
        window.sessionStorage.removeItem('user');
        window.location.href = '/';
    }

    return (
        <>
            <Navbar bg="dark" data-bs-theme="dark">
                <Container>
                    <Navbar.Brand href="/">HR sistem SSFON</Navbar.Brand>
                    <Nav className="me-auto">
                        <Nav.Link href="/">Pocetna</Nav.Link>
                        <Nav.Link href="/projekti">Projekti</Nav.Link>
                        {
                            ulogovan && <Nav.Link href="/clanovi">Clanovi</Nav.Link>
                        }
                        {
                            ulogovan && <Nav.Link href="/aktivnosti">Aktivnosti</Nav.Link>
                        }
                        {
                            admin && <Nav.Link href="/administracija">Administracija</Nav.Link>
                        }

                    </Nav>
                    <Nav className="justify-content-end">
                        {
                            ulogovan && <Nav.Link href="/moj-profil">Moj profil</Nav.Link>
                        }
                        {
                            !ulogovan && <Nav.Link href="/login">Prijavi se</Nav.Link>
                        }
                        {
                            ulogovan && <Nav.Link href="#" onClick={
                                () => {
                                    odjaviSe();
                                }
                            }>Odjavi se</Nav.Link>
                        }
                    </Nav>
                </Container>
            </Navbar>
        </>
    );
};

export default Navigacija;