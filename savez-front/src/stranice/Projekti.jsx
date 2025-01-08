import React, {useEffect} from 'react';
import server from "../pomocne/server";
import {Accordion, Col, Row, Table} from "react-bootstrap";
import Projekat from "../komponente/Projekat";
const Projekti = () => {

    const [projekti, setProjekti] = React.useState([]);
    const [prijateljiProjekata, setPrijateljiProjekata] = React.useState([]);


    useEffect(() => {
        server.get('/projekti').then(res => {
            console.log(res);
            setProjekti(res.data.podaci);
        }).catch(err => {
            console.log(err);
        })
    }, []);

    useEffect(() => {
        server.get('https://randomuser.me/api/?results=5').then(res => {
            console.log(res);
            setPrijateljiProjekata(res.data.results);
        }).catch(err => {
            console.log(err);
        })
    }, []);

    return (
        <>
            <h1 className="main-title text-center p-1 mt-3">Projekti</h1>

            <Accordion defaultActiveKey="0">
                {
                    projekti.map((projekat, index) => {
                        return (
                            <Projekat nazivProjekta={projekat.nazivProjekta} eventKey={index.toString()} key={projekat.id} datumPocetka={projekat.datumPocetka} datumZavrsetka={projekat.datumZavrsetka} opisProjekta={projekat.opisProjekta} />
                        )
                    })
                }
            </Accordion>

            <Row>
                <Col md={12}>
                    <h1 className="main-title text-center p-1 mt-3">Prijatelji projekata</h1>
                    <Table hover>
                        <thead>
                            <tr>
                                <th>Ime</th>
                                <th>Prezime</th>
                                <th>Email</th>
                                <th>Broj telefona</th>
                            </tr>
                        </thead>
                        <tbody>
                        {
                            prijateljiProjekata.map((prijatelj, index) => {
                                return (
                                    <tr key={index}>
                                        <td>{prijatelj.name.first}</td>
                                        <td>{prijatelj.name.last}</td>
                                        <td>{prijatelj.email}</td>
                                        <td>{prijatelj.phone}</td>
                                    </tr>
                                )
                            })
                        }
                        </tbody>
                    </Table>
                </Col>
            </Row>

        </>
    );
};

export default Projekti;