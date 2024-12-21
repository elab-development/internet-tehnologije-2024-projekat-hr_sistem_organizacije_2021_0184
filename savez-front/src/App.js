import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import {Alert, Container} from "react-bootstrap";
import Navigacija from "./komponente/Navigacija";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import Pocetna from "./stranice/Pocetna";
import Projekti from "./stranice/Projekti";
import Aktivnosti from "./stranice/Aktivnosti";
import Clanovi from "./stranice/Clanovi";
import MojProfil from "./stranice/MojProfil";
import Prijava from "./stranice/Prijava";
import Administracija from "./stranice/Administracija";

function App() {
  return (

      <>
          <Navigacija />
          <Container>

              <BrowserRouter>
                  <Routes>
                      <Route path="/" element={<Pocetna />} />
                      <Route path="/projekti" element={<Projekti />} />
                      <Route path="/aktivnosti" element={<Aktivnosti />} />
                      <Route path="/clanovi" element={<Clanovi />} />
                      <Route path="/moj-profil" element={<MojProfil />} />
                      <Route path="/login" element={<Prijava />} />
                      <Route path="/administracija" element={<Administracija />} />
                  </Routes>
              </BrowserRouter>

          </Container>
      </>

  );
}

export default App;
