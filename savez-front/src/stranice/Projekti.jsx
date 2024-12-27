import React, {useEffect} from 'react';
import server from "../pomocne/server";
import {Accordion} from "react-bootstrap";
import Projekat from "../komponente/Projekat";
const Projekti = () => {

    const [projekti, setProjekti] = React.useState([]);

    useEffect(() => {
        server.get('/projekti').then(res => {
            console.log(res);
            setProjekti(res.data.podaci);
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

        </>
    );
};

export default Projekti;