import React from 'react';
import PropTypes from 'prop-types';
import {Card} from "react-bootstrap";
import {MdEmail} from "react-icons/md";
import {FaPhone} from "react-icons/fa";

const Clan = props => {
    const {clan} = props;
    const timskaKlasa = "tim-" + clan.tim.skraceniNazivTima + " clan-card mt-3";
    return (
        <>
            <Card className={timskaKlasa}>
                <Card.Img variant="top" src={
                    clan.slika
                } />
                <Card.Body>
                    <Card.Title>{clan.imePrezime} - <span>({ clan.tim.skraceniNazivTima})</span></Card.Title>
                    <Card.Text>
                        <MdEmail /> {clan.email} <br />
                        <FaPhone /> {clan.telefon}
                        <br/>
                        {clan.napomena}
                    </Card.Text>
                </Card.Body>
            </Card>
        </>
    );
};

Clan.propTypes = {
    clan: PropTypes.object.isRequired
};

export default Clan;