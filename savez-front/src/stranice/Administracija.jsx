import React, {useEffect} from 'react';
import {Alert, Button, Col, Form, Row, Table} from "react-bootstrap";
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
    const [url, setUrl] = React.useState('/paginacija');
    const [linkovi, setLinkovi] = React.useState([]);
    const [podaci, setPodaci] = React.useState([]);
    const [timovi, setTimovi] = React.useState([]);

    const slikaRef = React.useRef();

    const {formData, handleChange} = useForm({
        'clanPovezi': -1,
        'korisnikPovezi': -1,
        'clanAktivnost': -1,
        'aktivnost': -1,
        'aktivnostClanaOcena': -1,
        'ocena': 0,
        'imePrezime': '',
        'email': '',
        'adresa': '',
        'telefon': '',
        'datumRodjenja': '',
        'pol': 'M',
        'datumPristupa': '',
        'datumIsteka': null,
        'napomena': '',
        'timId': 1,
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
        server.get('/timovi').then(res => {
            console.log(res);
            setTimovi(res.data.podaci);
        }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom ucitavanja timova');
        })
    }, []);

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

    //paginacija
    useEffect(() => {

        server.get(url).then(res => {
            console.log(res);
            console.log('paginacija');
            setPodaci(res.data.podaci.data);


            let linkoviDugmici = [];

            //foreach res.data.podaci.links
            console.log(res.data.podaci.links);

            res.data.podaci.links.forEach(link => {

                if ('&laquo; Previous' === link.label){
                    link.label = 'Prethodna';
                }

                if ('Next &raquo;' === link.label){
                    link.label = 'Sledeca';
                }

                linkoviDugmici.push({
                    url: link.url,
                    label: link.label,
                    active: link.active
                });
            });

            setLinkovi(linkoviDugmici);
        }).catch(err => {
            console.log(err);
        })
    }, [url]);

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

    const unesiClana = () => {
        let slikaFile = slikaRef.current.files[0];

        let formToSend = new FormData();
        formToSend.append('imePrezime', formData.imePrezime);
        formToSend.append('email', formData.email);
        formToSend.append('adresa', formData.adresa);
        formToSend.append('telefon', formData.telefon);
        formToSend.append('datumRodjenja', formData.datumRodjenja);
        formToSend.append('pol', formData.pol);
        formToSend.append('datumPristupa', formData.datumPristupa);
        formToSend.append('datumIsteka', formData.datumIsteka);
        formToSend.append('napomena', formData.napomena);
        formToSend.append('timId', formData.timId);
        formToSend.append('slikaFajl', slikaFile);

        server.post('/clanovi', formToSend).then(res => {
            console.log(res);
            if (res.data.uspesno === true){
                setUspesnaPoruka('Uspesno unet clan');
                setOsvezi(!osvezi);
            }else{
                setPoruka(res.data.poruka);
            }
        }).catch(err => {
            console.log(err);
            setPoruka('Greska prilikom unosa clana');
        });

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

            <Row>
                <Col md={12}>
                    <h1 className="main-title text-center p-1 mt-3">Unos novog clana</h1>
                    <Form.Label className="m-1" column={1}>Ime i prezime</Form.Label>
                    <Form.Control name="imePrezime" onChange={handleChange} type="text" placeholder="Unesite ime i prezime" />
                    <Form.Label className="m-1" column={1}>Email</Form.Label>
                    <Form.Control name="email" onChange={handleChange} type="email" placeholder="Unesite email" />
                    <Form.Label className="m-1" column={1}>Adresa</Form.Label>
                    <Form.Control name="adresa" onChange={handleChange} type="text" placeholder="Unesite adresu" />
                    <Form.Label className="m-1" column={1}>Telefon</Form.Label>
                    <Form.Control name="telefon" onChange={handleChange} type="text" placeholder="Unesite telefon" />
                    <Form.Label className="m-1" column={1}>Datum rodjenja</Form.Label>
                    <Form.Control name="datumRodjenja" onChange={handleChange} type="text" placeholder="yyyy-MM-dd" />
                    <Form.Label className="m-1" column={1}>Pol</Form.Label>
                    <Form.Select name="pol" onChange={handleChange} className="p-1 m-1">
                        <option value="M">Muski</option>
                        <option value="Z">Zenski</option>
                    </Form.Select>
                    <Form.Label className="m-1" column={1}>Datum pristupa</Form.Label>
                    <Form.Control name="datumPristupa" onChange={handleChange} type="text" placeholder="yyyy-MM-dd" />
                    <Form.Label className="m-1" column={1}>Datum isteka</Form.Label>
                    <Form.Control name="datumIsteka" onChange={handleChange} type="text" placeholder="yyyy-MM-dd" />
                    <Form.Label className="m-1" column={1}>Napomena</Form.Label>
                    <Form.Control name="napomena" onChange={handleChange} type="text" placeholder="Unesite napomenu" />
                    <Form.Label className="m-1" column={1}>Tim</Form.Label>
                    <Form.Select name="timId" onChange={handleChange} className="p-1 m-1">
                        {
                            timovi.map((tim, index) => {
                                return (
                                    <option value={tim.id} key={tim.id}>{tim.nazivTima}</option>
                                )
                            })
                        }
                    </Form.Select>

                    <Form.Label className="m-1" column={1}>Slika</Form.Label>
                    <Form.Control ref={slikaRef} name="slika" onChange={handleChange} type="file" />

                    <hr/>

                    <Button onClick={unesiClana} className="m-1" variant="dark">Unesi clana</Button>

                </Col>
            </Row>

            <Row>
                <Col md={12}>
                    <h1 className="main-title text-center p-1 mt-3">Clanovi Projekta</h1>
                    <Table striped>
                        <thead>
                        <tr>
                            <th>Clan</th>
                            <th>Projekat</th>
                            <th>Uloga</th>
                        </tr>
                        </thead>
                        <tbody>
                        {
                            podaci.map((clanProjekta, index) => {
                                return (
                                    <tr key={clanProjekta.clanProjektaId}>
                                        <td>{clanProjekta.imePrezime}</td>
                                        <td>{clanProjekta.nazivProjekta}</td>
                                        <td>{clanProjekta.uloga}</td>
                                    </tr>
                                )
                            })
                        }
                        </tbody>
                    </Table>
                    {
                        linkovi !== [] && (
                                <>
                                    {
                                        linkovi.map((link, index) => {
                                            return (
                                                <Button key={index} onClick={
                                                    () => {
                                                        setUrl(link.url);
                                                    }
                                                } disabled={link.active || link.url === null} className="m-1" variant="dark">{link.label}</Button>
                                            )
                                        })
                                    }
                                </>

                        )
                    }
                </Col>
            </Row>

        </>
    );
};

export default Administracija;