import logo from '../assets/logo.png';

function Footer() {
  // UFC-style footer styles (added)
  const styles = {
    footer: {
      
      
      padding: '20px 24px',
      borderTop: '2px solid #e50914',
      // Make the footer stay fixed at the bottom of the viewport
  
      bottom: 0,
      left: 0,
      right: 0,
      width: '100%',
      zIndex: 1000,
    },
    container: { maxWidth: '1200px', margin: '0 auto' },
    topRow: {
      display: 'flex',
      flexWrap: 'wrap',
      alignItems: 'center',
      justifyContent: 'space-between',
      gap: '24px',
    },
    brand: { display: 'flex', alignItems: 'center', gap: '12px' },
    logoBadge: {
      width: '48px',
      height: '48px',
      borderRadius: '50%',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',

      fontSize: '24px',
    },
    brandText: { fontWeight: 800, fontSize: '22px', letterSpacing: '0.5px' },
    tagline: { fontSize: '12px', color: '#9ca3af' },
    
    grid: {
      display: 'grid',
      gridTemplateColumns: 'repeat(4,minmax(0,1fr))',
      gap: '16px',
      marginTop: '24px',
    },
    columnTitle: { fontWeight: 700, marginBottom: '8px', fontSize: '14px' },
    link: {
      display: 'block',
      color: '#cbd5e1',
      textDecoration: 'none',
      padding: '4px 0',
    },
    socialRow: { display: 'flex', gap: '12px', marginTop: '20px' },
    socialBtn: {
      width: '36px',
      height: '36px',
      borderRadius: '8px',
      background: '#111827',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      border: '1px solid #374151',
      color: '#e5e7eb',
      cursor: 'pointer',
    },
    divider: { borderTop: '1px solid #1f2937', marginTop: '24px' },
    bottomRow: {
      display: 'flex',
      flexWrap: 'wrap',
      justifyContent: 'space-between',
      alignItems: 'center',
      gap: '12px',
      paddingTop: '16px',
      fontSize: '12px',
      color: '#9ca3af',
    },
    legalLinks: { display: 'flex', gap: '12px' },
  };

  return (
    <div>
      {/* UFC-style footer markup (added) */}
      <footer style={styles.footer} aria-label="Footer">
        <div style={styles.container}>
          {/* Top row: brand + CTA */}
          <div style={styles.topRow}>
            <div style={styles.brand}>
              <div style={styles.logoBadge} aria-hidden="true">
                <img src={logo} alt="El Tigre logo" style={{ width: '32px', height: '32px', objectFit: 'contain' }} />
              </div>
              <div>
                <div style={styles.brandText}>El Tigre Club de Box</div>
                <div style={styles.tagline}>Power. Discipline. Heart.</div>
              </div>
            </div>

            
          </div>

          {/* Navigation grid */}
          <div style={styles.grid}>
            <div>
              <div style={styles.columnTitle}>Club</div>
              <a href="#history" style={styles.link}>History</a>
              <a href="#coaches" style={styles.link}>Coaches</a>
              <a href="#testimonials" style={styles.link}>Testimonials</a>
            </div>
            <div>
              <div style={styles.columnTitle}>Training</div>
              <a href="#classes" style={styles.link}>Classes</a>
              <a href="#youth" style={styles.link}>Youth Program</a>
              <a href="#private" style={styles.link}>Private Sessions</a>
            </div>
            <div>
              <div style={styles.columnTitle}>Membership</div>
              <a href="#plans" style={styles.link}>Plans</a>
              <a href="#promos" style={styles.link}>Promotions</a>
              <a href="#day-pass" style={styles.link}>Day Pass</a>
            </div>
            <div>
              <div style={styles.columnTitle}>Shop</div>
              <a href="#apparel" style={styles.link}>Apparel</a>

              <a href="#gift-cards" style={styles.link}>Gift Cards</a>
              <a href="#contact" style={styles.link}>Contact</a>
            </div>
          </div>

          {/* Social links */}
          <div style={styles.socialRow} aria-label="Social Links">
            <a style={styles.socialBtn} href="https://instagram.com" target="_blank" rel="noreferrer" aria-label="Instagram">
              {/* Instagram icon */}
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="5" stroke="#e5e7eb" strokeWidth="1.5" />
                <circle cx="12" cy="12" r="4" stroke="#e5e7eb" strokeWidth="1.5" />
                <circle cx="17.5" cy="6.5" r="1.25" fill="#e5e7eb" />
              </svg>
            </a>
            <a style={styles.socialBtn} href="https://youtube.com" target="_blank" rel="noreferrer" aria-label="YouTube">
              {/* YouTube icon */}
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <rect x="3" y="6" width="18" height="12" rx="3" stroke="#e5e7eb" strokeWidth="1.5" />
                <polygon points="10,9 16,12 10,15" fill="#e5e7eb" />
              </svg>
            </a>
            <a style={styles.socialBtn} href="https://tiktok.com" target="_blank" rel="noreferrer" aria-label="TikTok">
              {/* TikTok icon (simplified) */}
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M14 4c1.2 1.8 2.6 2.8 4.5 3v3c-1.9-.2-3.1-.9-4.5-2v5.7c0 3.6-2.6 5.3-5 5.3-2.4 0-4.5-1.6-4.5-4.2 0-2.6 2-4.2 4.1-4.4v3c-.8.1-1.5.7-1.5 1.5 0 1 .9 1.5 1.9 1.5 1.2 0 2.5-.8 2.5-2.7V4h2.5z" fill="#e5e7eb" />
              </svg>
            </a>
            <a style={styles.socialBtn} href="https://facebook.com" target="_blank" rel="noreferrer" aria-label="Facebook">
              {/* Facebook icon */}
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M14 8h3V5h-3c-2.2 0-4 1.8-4 4v3H7v3h3v6h3v-6h3l1-3h-4V9c0-.6.4-1 1-1z" fill="#e5e7eb" />
              </svg>
            </a>
          </div>

          <div style={styles.divider}></div>

          {/* Bottom row: legal */}
          <div style={styles.bottomRow}>
            <div>© 2025 El Tigre Club de Box. All rights reserved.</div>
            <div style={styles.legalLinks}>
              <a href="#privacy" style={{ color: '#9ca3af', textDecoration: 'none' }}>Privacy Policy</a>
              <a href="#terms" style={{ color: '#9ca3af', textDecoration: 'none' }}>Terms of Service</a>
              <a href="#cookies" style={{ color: '#9ca3af', textDecoration: 'none' }}>Cookies</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  )
}

export default Footer
