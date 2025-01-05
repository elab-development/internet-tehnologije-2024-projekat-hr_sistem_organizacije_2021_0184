import React, {useEffect} from 'react';
import {Row, Table} from "react-bootstrap";
import server from "../pomocne/server";

const Aktivnosti = () => {

    const [aktivnosti, setAktivnosti] = React.useState([]);

    useEffect(() => {
        server.get('/aktivnosti').then(res => {
            console.log(res);
            setAktivnosti(res.data.podaci);
        }).catch(err => {
            console.log(err);
        })
    }, []);

    return (
        <>
            <h1 className="main-title text-center p-1 mt-3">Aktivnosti</h1>

            <Row className="mt-3">
                <Table striped hover>
                    <thead>
                    <tr>
                        <th>Naziv</th>
                        <th>Opis</th>
                        <th>Rok</th>
                        <th>Projekat</th>
                        <th>Poeni</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    {
                        aktivnosti.map((aktivnost, index) => {

                            let klasa = '';

                            switch (aktivnost.status) {
                                case 'Inicijalizovana':
                                    klasa = 'table-info';
                                    break;
                                case 'U toku':
                                    klasa = 'table-warning';
                                    break;
                                case 'Zavrsena':
                                    klasa = 'table-success';
                                    break;
                                default:
                                    klasa = 'table-dark';
                                    break;
                            }

                            return (
                                <tr key={aktivnost.id} className={klasa}>
                                    <td>{aktivnost.nazivAktivnosti}</td>
                                    <td>{aktivnost.opisAktivnosti}</td>
                                    <td>{aktivnost.rok}</td>
                                    <td>{aktivnost.projekat.nazivProjekta}</td>
                                    <td>{aktivnost.poeni}</td>
                                    <td>{aktivnost.status}</td>
                                </tr>
                            )
                        })
                    }
                    </tbody>
                </Table>
            </Row>
        </>
    );
};

export default Aktivnosti;