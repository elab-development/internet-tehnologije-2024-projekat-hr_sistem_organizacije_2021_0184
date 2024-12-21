import React from 'react';
import PropTypes from 'prop-types';

const ONama = props => {
    const {naslov, tekst, slika} = props;
    return (
        <div className="onama-background">
            <h1 className="main-title text-center p-1 mt-3">{naslov}</h1>
            <p className="text-muted">{tekst}</p>
            <img className="img-thumbnail" src={slika} alt={naslov} />
        </div>
    );
};

ONama.propTypes = {
    naslov : PropTypes.string.isRequired,
    tekst : PropTypes.string.isRequired,
    slika : PropTypes.string.isRequired,
};

export default ONama;