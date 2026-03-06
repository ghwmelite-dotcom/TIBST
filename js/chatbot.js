// ===== TIBST 3-TIER CHATBOT =====

const CHATBOT_FAQ = [
  {
    question: "How do I apply?",
    answer: 'Visit our <a href="admissions.html">Admissions page</a> for step-by-step instructions. You can also apply directly through our <a href="portal.html">Student Portal</a>. The 2026/2027 intake is currently open!'
  },
  {
    question: "What programs are available?",
    answer: 'We offer postgraduate programmes in cutting-edge biomedical fields:<br><br>&bull; MPhil Gene Therapy (2-3 years)<br>&bull; PhD Gene Therapy (2-3 years)<br>&bull; MPhil Human Embryology (2-3 years)<br>&bull; PhD Human Embryology (2-3 years)<br>&bull; Certificate Programmes<br><br>Visit <a href="academics.html">Academics</a> for full details.'
  },
  {
    question: "What are the fees?",
    answer: 'Tuition fees vary by programme and student category. Visit our <a href="admissions.html#fees">Admissions page</a> for the detailed fee structure. Financial aid and sponsorship options are also available.'
  },
  {
    question: "Contact information?",
    answer: '<strong>Phone:</strong> +233 302 957 663<br><strong>Mobile:</strong> +233 277 715 058<br><strong>Email:</strong> info@thrivusinstitute.edu.gh<br><strong>Address:</strong> Constellations Avenue, Lashibi - Accra<br><br>Or click "Talk to a Person" below to chat on WhatsApp!'
  },
  {
    question: "When is the next intake?",
    answer: 'The <strong>2026/2027 academic year</strong> admissions are currently open. Apply early to secure your spot! Visit our <a href="admissions.html">Admissions page</a> to begin your application.'
  },
  {
    question: "Is financial aid available?",
    answer: 'Yes! TIBST offers financial aid and sponsorship opportunities for qualifying students. Visit our <a href="admissions.html#financial-aid">Financial Aid section</a> for eligibility criteria and how to apply.'
  },
  {
    question: "Where is TIBST located?",
    answer: 'TIBST is located at <strong>Constellations Avenue, Lashibi - Accra, Ghana</strong>. Visit our <a href="contact.html">Contact page</a> for directions and a map.'
  },
  {
    question: "Research opportunities?",
    answer: 'TIBST has active research units including our Translational Research Unit and Research Support Units. We welcome research collaborations. Visit our <a href="research.html">Research page</a> for more details.'
  }
];

// University knowledge base for AI mode
const UNIVERSITY_CONTEXT = `You are a helpful assistant for Thrivus Institute of Biomedical Sciences & Technology (TIBST), located at Constellations Avenue, Lashibi - Accra, Ghana.

Key facts:
- Programs: MPhil Gene Therapy, PhD Gene Therapy, MPhil Human Embryology, PhD Human Embryology, Certificate Programmes
- Program duration: 2-3 years
- Contact: Phone +233 302 957 663, Mobile +233 277 715 058, Email info@thrivusinstitute.edu.gh
- 2026/2027 admissions are open
- Financial aid and sponsorship available
- Research units: Translational Research Unit, Research Support Units
- Tagline: "Your career starts with us"
- Motto: "Prepare to be challenged"

Answer questions helpfully and concisely. If you don't know something specific, direct them to contact the university.`;

class TIBSTChatbot {
  constructor() {
    this.isOpen = false;
    this.currentMode = 'faq';
    this.messages = [];
    this.apiKey = null;
    this.apiProvider = 'openai'; // 'openai' or 'anthropic'
    this.init();
  }

  init() {
    this.createWidget();
    this.bindEvents();
    this.addBotMessage("Hello! Welcome to Thrivus Institute of Biomedical Sciences & Technology. How can I help you today?");
  }

  createWidget() {
    // Toggle button
    const toggle = document.createElement('button');
    toggle.className = 'chatbot-toggle';
    toggle.id = 'chatbot-toggle';
    toggle.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>`;
    toggle.setAttribute('aria-label', 'Open chat');

    // Chat window
    const window = document.createElement('div');
    window.className = 'chatbot-window';
    window.id = 'chatbot-window';
    window.innerHTML = `
      <div class="chatbot-header">
        <div class="chatbot-header-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
        </div>
        <div class="chatbot-header-text">
          <h4>TIBST Assistant</h4>
          <span>We're here to help</span>
        </div>
      </div>
      <div class="chatbot-messages" id="chatbot-messages"></div>
      <div class="chat-faq-buttons" id="chat-faq-buttons"></div>
      <div class="chatbot-input-area">
        <input type="text" class="chatbot-input" id="chatbot-input" placeholder="Type your question..." />
        <button class="chatbot-send" id="chatbot-send" aria-label="Send message">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
        </button>
      </div>
      <div class="chatbot-modes">
        <button class="chatbot-mode-btn active" data-mode="faq">FAQ</button>
        <button class="chatbot-mode-btn" data-mode="ai">AI Assistant</button>
        <button class="chatbot-mode-btn" data-mode="live">Talk to a Person</button>
      </div>
    `;

    document.body.appendChild(toggle);
    document.body.appendChild(window);
  }

  bindEvents() {
    // Toggle chat
    document.getElementById('chatbot-toggle').addEventListener('click', () => {
      this.toggleChat();
    });

    // Send message
    document.getElementById('chatbot-send').addEventListener('click', () => {
      this.handleSend();
    });

    document.getElementById('chatbot-input').addEventListener('keypress', (e) => {
      if (e.key === 'Enter') this.handleSend();
    });

    // Mode switching
    document.querySelectorAll('.chatbot-mode-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        this.switchMode(btn.getAttribute('data-mode'));
      });
    });
  }

  toggleChat() {
    this.isOpen = !this.isOpen;
    const window = document.getElementById('chatbot-window');
    const toggle = document.getElementById('chatbot-toggle');

    if (this.isOpen) {
      window.classList.add('active');
      toggle.classList.add('active');
      toggle.innerHTML = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`;
      this.showFAQButtons();
      document.getElementById('chatbot-input').focus();
    } else {
      window.classList.remove('active');
      toggle.classList.remove('active');
      toggle.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>`;
    }
  }

  switchMode(mode) {
    this.currentMode = mode;

    // Update active button
    document.querySelectorAll('.chatbot-mode-btn').forEach(btn => {
      btn.classList.toggle('active', btn.getAttribute('data-mode') === mode);
    });

    const faqContainer = document.getElementById('chat-faq-buttons');
    const input = document.getElementById('chatbot-input');

    if (mode === 'faq') {
      this.showFAQButtons();
      input.placeholder = 'Or type your question...';
    } else if (mode === 'ai') {
      faqContainer.innerHTML = '';
      input.placeholder = 'Ask me anything about TIBST...';
      if (!this.messages.some(m => m.text.includes('AI Assistant'))) {
        this.addBotMessage("You're now chatting with our AI Assistant. Ask me anything about TIBST's programs, admissions, research, and more!");
      }
    } else if (mode === 'live') {
      faqContainer.innerHTML = `
        <div style="width:100%; text-align:center; padding: 12px 0;">
          <p style="font-size: 0.85rem; color: #6b7280; margin-bottom: 12px;">Connect with our staff on WhatsApp for immediate assistance.</p>
          <a href="https://wa.me/233277715058" target="_blank" class="btn btn-primary btn-sm" style="background: #25D366; box-shadow: 0 4px 15px rgba(37,211,102,0.3);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.625.846 5.059 2.284 7.034L.789 23.492a.5.5 0 00.611.611l4.458-1.495A11.948 11.948 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-2.329 0-4.521-.638-6.4-1.746l-.446-.266-3.148 1.055 1.055-3.148-.266-.446A9.96 9.96 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            Chat on WhatsApp
          </a>
          <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 10px;">Available Mon-Fri, 8:00 AM - 5:00 PM GMT</p>
        </div>
      `;
      input.placeholder = 'Or type a message...';
    }
  }

  showFAQButtons() {
    const container = document.getElementById('chat-faq-buttons');
    container.innerHTML = CHATBOT_FAQ.map((faq, i) =>
      `<button class="faq-btn" data-faq="${i}">${faq.question}</button>`
    ).join('');

    container.querySelectorAll('.faq-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const index = parseInt(btn.getAttribute('data-faq'));
        this.addUserMessage(CHATBOT_FAQ[index].question);
        this.addBotMessage(CHATBOT_FAQ[index].answer);
      });
    });
  }

  handleSend() {
    const input = document.getElementById('chatbot-input');
    const message = input.value.trim();
    if (!message) return;

    this.addUserMessage(message);
    input.value = '';

    if (this.currentMode === 'ai') {
      this.handleAIQuery(message);
    } else {
      this.handleFAQSearch(message);
    }
  }

  handleFAQSearch(message) {
    const lower = message.toLowerCase();

    // Try to match FAQ
    const match = CHATBOT_FAQ.find(faq => {
      const keywords = faq.question.toLowerCase().split(' ');
      return keywords.some(kw => kw.length > 3 && lower.includes(kw));
    });

    if (match) {
      this.addBotMessage(match.answer);
    } else {
      this.addBotMessage('I\'m not sure about that. You can try our <strong>AI Assistant</strong> mode for more detailed answers, or <strong>Talk to a Person</strong> to chat with our staff on WhatsApp.');
    }
  }

  async handleAIQuery(message) {
    // Show typing indicator
    this.addTypingIndicator();

    // Check for API key
    if (!this.apiKey) {
      this.removeTypingIndicator();
      // Fallback: use FAQ matching + generic helpful response
      const lower = message.toLowerCase();

      // Extended keyword matching
      if (lower.includes('apply') || lower.includes('admission') || lower.includes('enroll')) {
        this.addBotMessage('To apply to TIBST, visit our <a href="admissions.html">Admissions page</a> for requirements and the application process. The 2026/2027 intake is currently open!');
      } else if (lower.includes('program') || lower.includes('course') || lower.includes('study') || lower.includes('degree')) {
        this.addBotMessage('TIBST offers MPhil and PhD programmes in Gene Therapy and Human Embryology, plus Certificate Programmes. Visit <a href="academics.html">Academics</a> for full details.');
      } else if (lower.includes('fee') || lower.includes('cost') || lower.includes('tuition') || lower.includes('price')) {
        this.addBotMessage('For detailed fee information, please visit our <a href="admissions.html#fees">fee structure page</a> or contact us at info@thrivusinstitute.edu.gh.');
      } else if (lower.includes('contact') || lower.includes('phone') || lower.includes('email') || lower.includes('address') || lower.includes('location')) {
        this.addBotMessage('You can reach us at:<br><strong>Phone:</strong> +233 302 957 663<br><strong>Email:</strong> info@thrivusinstitute.edu.gh<br><strong>Address:</strong> Constellations Avenue, Lashibi - Accra');
      } else if (lower.includes('research') || lower.includes('lab')) {
        this.addBotMessage('TIBST has active research programmes including our Translational Research Unit. Visit our <a href="research.html">Research page</a> for details on ongoing projects and collaboration opportunities.');
      } else if (lower.includes('financial') || lower.includes('scholarship') || lower.includes('aid') || lower.includes('sponsor')) {
        this.addBotMessage('Yes, TIBST offers financial aid and sponsorship opportunities. Visit our <a href="admissions.html#financial-aid">Financial Aid section</a> for eligibility details.');
      } else if (lower.includes('library')) {
        this.addBotMessage('Our library offers extensive biomedical resources. Visit our <a href="library.html">Library page</a> for catalog access and digital resources.');
      } else if (lower.includes('hello') || lower.includes('hi') || lower.includes('hey')) {
        this.addBotMessage('Hello! How can I help you today? You can ask me about our programmes, admissions, fees, research, or anything else about TIBST.');
      } else {
        this.addBotMessage('Thank you for your question. For the most accurate answer, I recommend contacting our admissions office at <strong>info@thrivusinstitute.edu.gh</strong> or <strong>+233 302 957 663</strong>. You can also switch to "Talk to a Person" to chat with staff on WhatsApp.');
      }
      return;
    }

    // If API key exists, call the AI
    try {
      let response;
      if (this.apiProvider === 'openai') {
        response = await this.callOpenAI(message);
      } else {
        response = await this.callAnthropic(message);
      }
      this.removeTypingIndicator();
      this.addBotMessage(response);
    } catch (error) {
      this.removeTypingIndicator();
      this.addBotMessage('Sorry, I encountered an error. Please try again or contact us directly at info@thrivusinstitute.edu.gh.');
    }
  }

  async callOpenAI(message) {
    const res = await fetch('https://api.openai.com/v1/chat/completions', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${this.apiKey}`
      },
      body: JSON.stringify({
        model: 'gpt-4o-mini',
        messages: [
          { role: 'system', content: UNIVERSITY_CONTEXT },
          { role: 'user', content: message }
        ],
        max_tokens: 300
      })
    });
    const data = await res.json();
    return data.choices[0].message.content;
  }

  async callAnthropic(message) {
    const res = await fetch('https://api.anthropic.com/v1/messages', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'x-api-key': this.apiKey,
        'anthropic-version': '2023-06-01',
        'anthropic-dangerous-direct-browser-access': 'true'
      },
      body: JSON.stringify({
        model: 'claude-haiku-4-5-20251001',
        max_tokens: 300,
        system: UNIVERSITY_CONTEXT,
        messages: [{ role: 'user', content: message }]
      })
    });
    const data = await res.json();
    return data.content[0].text;
  }

  addBotMessage(html) {
    const container = document.getElementById('chatbot-messages');
    const msg = document.createElement('div');
    msg.className = 'chat-message bot';
    msg.innerHTML = html;
    container.appendChild(msg);
    container.scrollTop = container.scrollHeight;
    this.messages.push({ type: 'bot', text: html });
  }

  addUserMessage(text) {
    const container = document.getElementById('chatbot-messages');
    const msg = document.createElement('div');
    msg.className = 'chat-message user';
    msg.textContent = text;
    container.appendChild(msg);
    container.scrollTop = container.scrollHeight;
    this.messages.push({ type: 'user', text });
  }

  addTypingIndicator() {
    const container = document.getElementById('chatbot-messages');
    const indicator = document.createElement('div');
    indicator.className = 'chat-message bot';
    indicator.id = 'typing-indicator';
    indicator.innerHTML = '<span style="display:inline-flex;gap:4px;"><span style="width:6px;height:6px;background:#9ca3af;border-radius:50%;animation:typingDot 1.4s infinite ease-in-out;"></span><span style="width:6px;height:6px;background:#9ca3af;border-radius:50%;animation:typingDot 1.4s infinite ease-in-out 0.2s;"></span><span style="width:6px;height:6px;background:#9ca3af;border-radius:50%;animation:typingDot 1.4s infinite ease-in-out 0.4s;"></span></span>';
    container.appendChild(indicator);
    container.scrollTop = container.scrollHeight;

    // Add animation if not exists
    if (!document.getElementById('typing-style')) {
      const style = document.createElement('style');
      style.id = 'typing-style';
      style.textContent = '@keyframes typingDot{0%,60%,100%{transform:translateY(0)}30%{transform:translateY(-6px)}}';
      document.head.appendChild(style);
    }
  }

  removeTypingIndicator() {
    const indicator = document.getElementById('typing-indicator');
    if (indicator) indicator.remove();
  }
}

// Configure chatbot API (call this to enable AI mode)
// Example: configureChatbotAPI('your-api-key', 'openai')
function configureChatbotAPI(apiKey, provider = 'openai') {
  if (window.tibstChatbot) {
    window.tibstChatbot.apiKey = apiKey;
    window.tibstChatbot.apiProvider = provider;
  }
}

// Auto-init
document.addEventListener('DOMContentLoaded', () => {
  window.tibstChatbot = new TIBSTChatbot();
});
