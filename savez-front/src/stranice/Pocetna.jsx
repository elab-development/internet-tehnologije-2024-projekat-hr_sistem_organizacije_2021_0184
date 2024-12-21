import React from 'react';
import {Col, Container, Row} from "react-bootstrap";
import ONama from "../komponente/ONama";
import savez from "../slike/slika-org.jpg";
import hr from "../slike/slika-hr.jpg";

const Pocetna = () => {
    const niz = [
        {
            id : 1,
            naslov : "O nama",
            tekst : "Savez studenata Fakulteta organizacionih nauka je najstarija studentska organizacija osnovana 1991. godine. Tradicija duga 33 godine govori o tome da su ljudi, tradicija i kvalitet glavne determinante i stubovi opstanka organizacije.\n" +
                "Naša misija se ogleda u pružanju prilike mladim i ambicioznim ljudima da se tokom studiranja oprobaju u ulogama koje ih očekuju u poslovnom svetu.\n" +
                "U toku godine organizujemo 4 glavna projekta koji su namenjeni svim studentima Beogradskog univerziteta: Konferencija studenata organizacionih nauka, Dani prakse, SportBizz, GreenWay (StudRun).\n" +
                "Sa ponosom ističemo činjenicu da smo najbolje ocenjena studentska organizacija Univerziteta u Beogradu, kao i da akitvno učestvujemo u mnogim humanitarnim akcijama u saradnji sa našim dugogodišnjim partnerom, humanitarnom organizacijom Kolevka.",
            slika : savez
        },
        {
            id : 2,
            naslov : "HR sistem SSFON",
            tekst : "HR ogranak Saveza studenata Fakulteta organizacionih nauka (FON) ima za cilj unapređenje ljudskih resursa na fakultetu, kroz aktivno učešće u različitim projektima, organizovanje događaja, kao i pružanje podrške studentima u vezi sa njihovim profesionalnim razvojem. Članovi HR ogranka rade na povezivanju studenata sa potencijalnim poslodavcima, organizovanju obuka i radionica koje imaju za cilj jačanje veština i znanja iz oblasti upravljanja ljudskim resursima.\n" +
                "\n" +
                "Kroz različite inicijative i aktivnosti, HR ogranak teži da promoviše značaj ljudskih resursa kao ključnog faktora uspeha organizacija i pomaže studentima da steknu praktično iskustvo koje je od značaja za njihov profesionalni razvoj. Ogranak takođe pruža mogućnosti za umrežavanje, kao i platformu za razmenu ideja i iskustava između studenata i profesionalaca iz oblasti HR-a.\n" ,
            slika : hr
        }
    ]
    return (
        <>
            <Container>
                <Row>
                    {
                        niz.map((element, index) => {
                            return (
                                <Col md={6} key={index}>
                                   <ONama naslov={element.naslov} tekst={element.tekst} slika={element.slika} />
                                </Col>
                            );
                        })
                    }
                </Row>
            </Container>
        </>
    );
};

export default Pocetna;