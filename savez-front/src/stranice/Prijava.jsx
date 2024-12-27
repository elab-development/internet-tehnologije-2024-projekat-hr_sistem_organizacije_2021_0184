import React from 'react';
import {Button, Form} from "react-bootstrap";
import {Link} from "react-router-dom";
import {FaGear} from "react-icons/fa6";
import {FaDoorOpen, FaUser} from "react-icons/fa";
import useForm from "../pomocne/useForm";
import server from "../pomocne/server";

const Prijava = () => {

    const [isPrijava, setIsPrijava] = React.useState(true);

    const {formData, handleChange} = useForm({
        email: '',
        password: '',
        name: ''
    });

    const login = () => {
        console.log(formData);

        server.post('/login', formData).then(res => {
            console.log(res);
            window.sessionStorage.setItem('token', res.data.podaci.token);
            window.sessionStorage.setItem('user', JSON.stringify(res.data.podaci.user));
            window.location.href = '/';
        }).catch(err => {
            console.log(err);
        })

    }


    return (
        <>
            {
                isPrijava && (
                    <>
                        <h1 className="main-title text-center p-1 mt-3">Forma za prijavu</h1>
                        <Form>
                            <Form.Group className="mb-3" controlId="formBasicEmail">
                                <Form.Label>Email adresa</Form.Label>
                                <Form.Control type="email" name="email" onChange={handleChange} placeholder="Unesite email adresu" value={formData.email}/>
                            </Form.Group>

                            <Form.Group className="mb-3" controlId="formBasicPassword">
                                <Form.Label>Password</Form.Label>
                                <Form.Control name="password" onChange={handleChange} type="password" placeholder="Lozinka" value={formData.password} />
                            </Form.Group>
                            <a className="link-dark" href="#" onClick={
                                () => {
                                    setIsPrijava(false);
                                }
                            }>Nemate nalog, registrujte se</a>
                            <hr />
                            <Button variant="dark" type="button" onClick={login}>
                                Prijavi se <FaUser />
                            </Button>
                        </Form>
                    </>
                )
            }

            {
                !isPrijava && (
                    <>
                        <h1 className="main-title text-center p-1 mt-3">Forma za registraciju</h1>
                        <Form>
                            <Form.Group className="mb-3" controlId="formBasicName">
                                <Form.Label>Ime i prezime</Form.Label>
                                <Form.Control name="name" onChange={handleChange}  type="text" placeholder="Unesite ime i prezime" value={formData.name} />
                            </Form.Group>
                            <Form.Group className="mb-3" controlId="formBasicEmail1">
                                <Form.Label>Email adresa</Form.Label>
                                <Form.Control name="email" onChange={handleChange}  type="email" placeholder="Unesite email adresu" value={formData.email} />
                            </Form.Group>

                            <Form.Group className="mb-3" controlId="formBasicPassword1">
                                <Form.Label>Password</Form.Label>
                                <Form.Control name="password" onChange={handleChange}  type="password" placeholder="Lozinka" value={formData.password} />
                            </Form.Group>
                            <a className="link-dark" href="#" onClick={
                                () => {
                                    setIsPrijava(true);
                                }
                            }>Imate nalog, ulogujte se</a>
                            <hr />
                            <Button variant="dark" type="button">
                                Registruj se <FaUser />
                            </Button>
                        </Form>
                    </>
                )
            }

        </>
    );
};

export default Prijava;