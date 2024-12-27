import React from 'react';
import PropTypes from 'prop-types';
import {Accordion} from "react-bootstrap";

const Projekat = props => {
    const {nazivProjekta, opisProjekta, datumPocetka, datumZavrsetka, eventKey} = props;
    return (
        <>
            <Accordion.Item eventKey={eventKey} className="projekti">
                <Accordion.Header> <span>{nazivProjekta}</span> ({datumPocetka} - {datumZavrsetka})</Accordion.Header>
                <Accordion.Body>
                    {opisProjekta}
                </Accordion.Body>
            </Accordion.Item>
        </>
    );
};

Projekat.propTypes = {
    nazivProjekta : PropTypes.string.isRequired,
    opisProjekta : PropTypes.string.isRequired,
    datumPocetka : PropTypes.string.isRequired,
    datumZavrsetka : PropTypes.string.isRequired,
    eventKey : PropTypes.string.isRequired
};

export default Projekat;