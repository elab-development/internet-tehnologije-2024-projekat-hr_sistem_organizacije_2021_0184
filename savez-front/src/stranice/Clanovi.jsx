import React, {useEffect} from 'react';
import server from "../pomocne/server";
import {Col, Form, Row} from "react-bootstrap";
import Clan from "../komponente/Clan";
const Clanovi = () => {

    const [clanovi, setClanovi] = React.useState([]);
    const [timovi, setTimovi] = React.useState([]);
    const [izabraniTim, setIzabraniTim] = React.useState(0);

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