import React, {useEffect} from 'react';
import {Alert, Button, Col, Form, Row} from "react-bootstrap";
import {CgDanger} from "react-icons/cg";
import server from "../pomocne/server";
import useForm from "../pomocne/useForm";
import {FaInfo} from "react-icons/fa6";

const Administracija = () => {

    const [poruka, setPoruka] = React.useState('');
    const [uspesnaPoruka, setUspesnaPoruka] = React.useState('');
    const [clanovi, setClanovi] = React.useState([]);
    const [clanoviBezUsera, setClanoviBezUsera] = React.useState([]);
    const [korisnici, setKorisnici] = React.useState([]);
    const [aktivnosti, setAktivnosti] = React.useState([]);
    const [aktivnostiClana, setAktivnostiClana] = React.useState([]);
    const [osvezi, setOsvezi] = React.useState(false);

    const {formData, handleChange} = useForm({
        'clanPovezi': -1,
        'korisnikPovezi': -1,
        'clanAktivnost': -1,
        'aktivnost': -1,
        'aktivnostClanaOcena': -1,
        'ocena': 0,
    });

    useEffect(() => {

        server.get('/clanovi').then(res => {
            console.log(res);
            setClanovi(res.data.podaci);
            setClanoviBezUsera(res.data.podaci.filter(clan => clan.user === null));
        }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom ucitavanja clanova');
        })

    }, [osvezi]);

    useEffect(() => {
        server.get('/nepovezani-korisnici').then(res => {
            console.log(res);
            setKorisnici(res.data.podaci);
        }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom ucitavanja korisnika');
        })
    }, [osvezi]);

    useEffect(() => {
        server.get('/aktivnosti').then(res => {
            console.log(res);
            setAktivnosti(res.data.podaci);
        }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom ucitavanja aktivnosti');
        })
    }, []);

    useEffect(() => {
        server.get('/aktivnosti-clana').then(res => {
            console.log(res);
            setAktivnostiClana(res.data.podaci);
        }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom ucitavanja aktivnosti clana');
        })
    }, [osvezi]);

    const povezi = () => {
        console.log(formData);
        if (formData.clanPovezi === -1 || formData.korisnikPovezi === -1){
            setPoruka('Izaberite clana i korisnika');
            return;
        }

        server.get('/povezi/' + formData.clanPovezi + '/' + formData.korisnikPovezi)
            .then(res => {
                console.log(res);
                if (res.data.uspesno === true){
                    setUspesnaPoruka('Uspesno povezani');
                    setOsvezi(!osvezi);
                }else{
                    setPoruka(res.data.poruka);
                }
            }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom povezivanja');
        })

    }

    const dodeli = () => {

        if (formData.clanAktivnost === -1 || formData.aktivnost === -1){
            setPoruka('Izaberite clana i aktivnost');
            return;
        }

        server.post('/aktivnosti-clana/',{
            clanId: formData.clanAktivnost,
            aktivnostId: formData.aktivnost,
            ocena: 0
        })
            .then(res => {
                console.log(res);
                if (res.data.uspesno === true){
                    setUspesnaPoruka('Uspesno dodeljeno');
                    setOsvezi(!osvezi);
                }else{
                    setPoruka(res.data.poruka);
                }
            }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom dodeljivanja');
        })
    }

    const promeniOcenu = () => {
        if (formData.aktivnostClanaOcena === -1 || formData.ocena === ''){
            setPoruka('Izaberite aktivnost clana i unesite ocenu');
            return;
        }

        let aktivnost = aktivnostiClana.find(aktivnost => aktivnost.id === parseInt(formData.aktivnostClanaOcena));

        if (aktivnost.aktivnost.poeni < parseInt(formData.ocena)){
            setPoruka('Ocena ne moze biti veca od poena');
            return;
        }

        server.put('/promeni-ocenu/' + formData.aktivnostClanaOcena, {
            ocena: formData.ocena
        }).then(res => {
            console.log(res);
            if (res.data.uspesno === true){
                setUspesnaPoruka('Uspesno promenjena ocena');
                setOsvezi(!osvezi);
            }else{
                setPoruka(res.data.poruka);
            }
        }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom menjanja ocene');
        })
    }

    return (
        <>
            <h1 className="main-title text-center p-1 mt-3">Admin panel</h1>
            {
                poruka !== '' && (
                    <Alert className="mt-3" variant="danger">
                        <CgDanger /> {poruka}
                    </Alert>
                )
            }

            {
                uspesnaPoruka !== '' && (
                    <Alert className="mt-3" variant="success">
                        <FaInfo /> {uspesnaPoruka}
                    </Alert>
                )
            }

            <Row>
                <Col md={4}>
                    <h1 className="main-title text-center p-1 mt-3">Povezi usera sa clanom</h1>
                    <Form.Label className="m-1" column={1}>Izaberi clana</Form.Label>
                    <Form.Select name="clanPovezi" onChange={handleChange} className="p-1 m-1">
                        {
                            clanoviBezUsera.map((clan, index) => {
                                return (
                                    <option value={clan.id} key={clan.id}>{clan.imePrezime}</option>
                                )
                            })
                        }
                    </Form.Select>

                    <Form.Label className="m-1" column={1}>Izaberi korisnika</Form.Label>
                    <Form.Select name="korisnikPovezi" onChange={handleChange} className="p-1 m-1">
                        {
                            korisnici.map((clan, index) => {
                                return (
                                    <option value={clan.id} key={clan.id}>{clan.name}</option>
                                )
                            })
                        }
                    </Form.Select>
                    <hr/>
                    <Button onClick={povezi} className="m-1" variant="dark">Povezi</Button>
                </Col>

                <Col md={4}>
                    <h1 className="main-title text-center p-1 mt-3">Dodeli aktivnost</h1>
                    <Form.Label className="m-1" column={1}>Izaberi clana</Form.Label>
                    <Form.Select name="clanAktivnost" onChange={handleChange} className="p-1 m-1">
                        {
                            clanovi.map((clan, index) => {
                                return (
                                    <option value={clan.id} key={clan.id}>{clan.imePrezime}</option>
                                )
                            })
                        }
                    </Form.Select>
                    <Form.Label className="m-1" column={1}>Izaberi aktivnost</Form.Label>
                    <Form.Select name="aktivnost" onChange={handleChange} className="p-1 m-1">
                        {
                            aktivnosti.map((aktivnost, index) => {
                                return (
                                    <option value={aktivnost.id} key={aktivnost.id}>{aktivnost.nazivAktivnosti} ({ aktivnost.projekat.nazivProjekta})</option>
                                )
                            })
                        }
                    </Form.Select>
                    <hr/>
                    <Button onClick={dodeli} className="m-1" variant="dark">Dodeli</Button>
                </Col>

                <Col md={4}>
                    <h1 className="main-title text-center p-1 mt-3">Promeni ocenu</h1>
                    <Form.Label className="m-1" column={1}>Izaberi aktivnost clana</Form.Label>
                    <Form.Select name="aktivnostClanaOcena" onChange={handleChange} className="p-1 m-1">
                        {
                            aktivnostiClana.map((aktivnost, index) => {
                                return (
                                    <option value={aktivnost.id} key={aktivnost.id}>{aktivnost.aktivnost.nazivAktivnosti} ({ aktivnost.clan.imePrezime}) - {aktivnost.ocena} / {aktivnost.aktivnost.poeni}</option>
                                )
                            })
                        }
                    </Form.Select>
                    <Form.Label className="m-1" column={1}>Ocena</Form.Label>
                    <Form.Control name="ocena" onChange={handleChange} type="number" placeholder="Unesite ocenu" />
                    <hr/>
                    <Button onClick={promeniOcenu} className="m-1" variant="dark">Promeni ocenu</Button>
                </Col>
            </Row>

        </>
    );
};

export default Administracija;