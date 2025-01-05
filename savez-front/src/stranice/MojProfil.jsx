import React, {useEffect} from 'react';
import {Col, Row, Table} from "react-bootstrap";
import server from "../pomocne/server";
import {Chart} from "react-google-charts";

const MojProfil = () => {

    const user = JSON.parse(window.sessionStorage.getItem('user'));

    const [clan, setClan] = React.useState(null);
    const [mojeAktivnosti, setMojeAktivnosti] = React.useState([]);
    const [mojiProjekti, setMojiProjekti] = React.useState([]);
    const [podaciZaGrafik, setPodaciZaGrafik] = React.useState([]);

    useEffect(() => {
        server.get('/clanovi-user/' + user.id).then(res => {
            console.log(res);
            setClan(res.data.podaci);
        }).catch(err => {
            console.log(err);
        })
    }, [user.id]);

    useEffect(() => {
        if (clan !== null){
            server.get('/aktivnosti-clana/' + clan.id).then(res => {
                console.log(res);
                setMojeAktivnosti(res.data.podaci);

                let podaci = [];

                podaci.push(['Aktivnost', 'Poeni', 'Ocena']);

                res.data.podaci.forEach(aktivnost => {
                    podaci.push([
                        aktivnost.aktivnost.nazivAktivnosti,
                        aktivnost.aktivnost.poeni,
                        aktivnost.ocena
                    ]);
                })

                setPodaciZaGrafik(podaci);
            }).catch(err => {
                console.log(err);
            })

            server.get('/projekti-clana/' + clan.id).then(res => {
                console.log(res);
                setMojiProjekti(res.data.podaci);
            }).catch(err => {
                console.log(err);
            })
        }
    }, [clan]);

    return (
        <>
            {
                clan !== null && (
                    <>
                        <h1 className="main-title text-center p-1 mt-3">Profil: {user.name}</h1>
                        <Row>

                            <Col md={6}>
                                <h1 className="main-title text-center p-1 mt-3">Grafik aktivnosti</h1>
                                <Chart
                                    chartType="Bar"
                                    data={podaciZaGrafik}
                                    options={{
                                        chart: {
                                            title: 'Moje aktivnosti',
                                        },
                                    }}
                                />
                            </Col>
                            <Col md={6}>
                            <h1 className="main-title text-center p-1 mt-3">Moji projekti</h1>
                                <Table hover>
                                    <thead>
                                    <tr>
                                        <th>Naziv projekta</th>
                                        <th>Ime i prezime</th>
                                        <th>Uloga</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {
                                        mojiProjekti.map((projekat, index) => {
                                            return (
                                                <tr key={projekat.id}>
                                                    <td>{projekat.nazivProjekta}</td>
                                                    <td>{projekat.imePrezime}</td>
                                                    <td>{projekat.uloga}</td>
                                                </tr>
                                            )
                                        })
                                    }
                                    </tbody>
                                </Table>
                            </Col>

                            <Col md={12}>
                                <h1 className="main-title text-center p-1 mt-3">Moje aktivnosti</h1>
                                <Table striped>
                                    <thead>
                                    <tr>
                                        <th>Aktivnost</th>
                                        <th>Projekat</th>
                                        <th>Ime i prezime</th>
                                        <th>Ukupno poena</th>
                                        <th>Ocena</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {
                                        mojeAktivnosti.map((mojaAktivnost, index) => {
                                            return (
                                                <tr key={mojaAktivnost.id}>
                                                    <td>{mojaAktivnost.aktivnost.nazivAktivnosti}</td>
                                                    <td>{mojaAktivnost.aktivnost.projekat.nazivProjekta}</td>
                                                    <td>{mojaAktivnost.clan.imePrezime}</td>
                                                    <td>{mojaAktivnost.aktivnost.poeni}</td>
                                                    <td>{mojaAktivnost.ocena}</td>
                                                    <td>{mojaAktivnost.aktivnost.status}</td>
                                                </tr>
                                            )
                                        })
                                    }
                                    </tbody>
                                </Table>
                            </Col>

                        </Row>
                    </>
                )
            }

            {
                clan === null && (
                    <h1 className="bg-danger text-center p-1 mt-3">Vas profil nije povezan sa nijednim clanom, javite se adminu</h1>
                )
            }
        </>
    );
};

export default MojProfil;