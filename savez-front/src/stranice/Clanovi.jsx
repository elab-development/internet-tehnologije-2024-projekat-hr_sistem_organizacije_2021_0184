import React, {useEffect} from 'react';
import server from "../pomocne/server";
import {Button, Col, Form, Row} from "react-bootstrap";
import Clan from "../komponente/Clan";
import {CSVLink} from "react-csv";
const Clanovi = () => {

    const [clanovi, setClanovi] = React.useState([]);
    const [timovi, setTimovi] = React.useState([]);
    const [izabraniTim, setIzabraniTim] = React.useState(0);
    const [csvData, setCsvData] = React.useState([]);

    const isAdmin = JSON.parse(window.sessionStorage.getItem('user')).ulogaUSistemu === 'admin';

    useEffect(() => {

        let url = '/clanovi';

        if (parseInt(izabraniTim) !== 0) {
            url = 'pretraga-po-timu/' + izabraniTim;
        }else {
            url = '/clanovi';
        }

        server.get(url).then(res => {
            console.log(res);
            setClanovi(res.data.podaci);

            let data = [];

            res.data.podaci.forEach(clan => {
                data.push({
                    imePrezime: clan.imePrezime,
                    adresa: clan.adresa,
                    tim: clan.tim.nazivTima,
                    telefon: clan.telefon,
                    email: clan.email
                });
            });

            setCsvData(data);

        }).catch(err => {
            console.log(err);
        })
    }, [izabraniTim]);

    useEffect(() => {
        server.get('/timovi').then(res => {
            console.log(res);
            setTimovi(res.data.podaci);
        }).catch(err => {
            console.log(err);
        })
    }, []);

    return (
        <>
            <h1 className="main-title text-center p-1 mt-3">Clanovi</h1>

                <Form.Select className="p-1 m-1" onChange={
                    (e) => {
                        setIzabraniTim(e.target.value);
                    }
                }>
                    <option value={0}>Svi timovi</option>
                    {
                        timovi.map((tim, index) => {
                            return (
                                <option value={tim.id} key={tim.id}>{tim.nazivTima}</option>
                            )
                        })
                    }
                </Form.Select>

            { isAdmin &&
                <Row>
                    <CSVLink data={csvData}>Preuzmite podatke o clanovima</CSVLink>
                </Row>
            }

            <Row>
                {
                    clanovi.map((clan, index) => {
                        return (
                            <Col md={4} key={clan.id}>
                                <Clan clan={clan} />
                            </Col>
                        )
                    })
                }
            </Row>



        </>
    );
};

export default Clanovi;